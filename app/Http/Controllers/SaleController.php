<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\SaleDetail;
use App\Models\SaleOrder;
use App\Models\SalePayment;
use App\Models\SalesOrder;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date_range = $request->input('dateRange');
        $start_date = Carbon::today();
        $end_date = Carbon::today();
        $so_status = ($request->get("so_status") == "All" ? "" : $request->get("so_status"));
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        if ($date_range && strpos($date_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = Carbon::createFromFormat('d-M-Y', $start_date)->startOfDay();
            $end_date = Carbon::createFromFormat('d-M-Y', $end_date)->endOfDay();
        }

        if ($so_status != "") {
            $sale_orders = SaleOrder::whereBetween('date', [$start_date, $end_date])
                ->where('status', $so_status)
                ->where('id', 'like', '%' . $search . '%')
                ->paginate(10);
        } else {
            $sale_orders = SaleOrder::whereBetween('date', [$start_date, $end_date])
                ->where('id', 'like', '%' . $search . '%')
                ->paginate(10);
        }

        return view('sale.index', [
            'sale_orders' => $sale_orders,
            'date_range' => $date_range,
            'so_status' => $so_status,
            'table_search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prefix = 'SO';
        $date = Carbon::now()->format('Ymd');

        // Count total order today
        $totalOrdersToday = SaleOrder::whereDate('created_at', Carbon::today())->count() + 1;

        $so_code = sprintf('%s%s-%03d', $prefix, $date, $totalOrdersToday);

        if (strtoupper($request->customer_name) == "GUEST" || "") {
        }

        // Store Sale Order
        $sale_order = new SaleOrder();
        $sale_order->code = $so_code;
        $sale_order->date = $request->get('datePicker');
        $sale_order->total_price = $request->get('total');
        $sale_order->status = "PROSES";
        $sale_order->payment_status = "Belum Bayar";
        $sale_order->customer_id = (strtoupper($request->customer_name) == "GUEST" || "")
            ? 1
            : Customer::create(['name' => $request->customer_name])->id;
        $sale_order->user_id = Auth::id();
        $sale_order->save();

        // Store Sale Detail
        for ($i = 0; $i < count($request->get('itemId')); $i++) {
            $sale_detail = new SaleDetail();
            $sale_detail->qty = $request->get('quantity')[$i];
            $sale_detail->price = intval(str_replace(',', '', $request->get('price')[$i]));
            $sale_detail->discount = intval(str_replace('.', '', $request->get('discount')[$i]));
            $sale_detail->total_price = $request->get('total_price_per_item')[$i];
            $sale_detail->item_id = $request->get('itemId')[$i];
            $sale_detail->sale_order_id = $sale_order->id;
            $sale_detail->save();

            // Update Stock on Warehouse
            $warehouse_item = WarehouseItem::find($request->get('warehouseItemId')[$i]);
            $warehouse_item->stock = $warehouse_item->stock - $sale_detail->qty;
            $warehouse_item->save();

            // Update master item stock
            $item = Item::find($sale_detail->item_id);
            $item->stock = $item->stock - $sale_detail->qty;
            $item->save();
        }

        return redirect()->route('sale.show', $sale_order->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($sale_id)
    {
        $sale_order = SaleOrder::find($sale_id);

        return view(
            'sale.detail',
            [
                'sale_order' => $sale_order,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleOrder $salesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleOrder $salesOrder)
    {
        //
    }

    public function autoCompleteCustomer(Request $request)
    {
        $data = Customer::select("id", "name as value")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();

        return response()->json($data);
    }

    public function autoCompleteItem(Request $request)
    {
        $data = Item::select("warehouse_items.id as warehouse_item_id", "warehouses.name", "items.id", DB::raw("CONCAT(warehouses.name,' - ',items.name, ' - ', warehouse_items.stock,' ' , units.name) as value"), "items.price", "warehouse_items.stock")
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->join('warehouse_items', 'warehouse_items.item_id', '=', 'items.id')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_items.warehouse_id')
            ->where('items.stock', '>', 0)
            ->where('items.name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();

        return response()->json($data);
    }

    public function print_pdf($sale_id)
    {
        $sale_order = SaleOrder::find($sale_id);
        $sale_order->date = Carbon::parse($sale_order->date)->format('d-m-Y');

        $sale_payment = SalePayment::where('sale_order_id', $sale_id)->get();
        $total_sale_payment = 0;

        foreach($sale_payment as $sp){
            $total_sale_payment += $sp->amount;
        }

        $data = [
            'sale_order' => $sale_order,
            'total_sale_payment' => $total_sale_payment,
        ];

        $pdf = Pdf::loadview('sale.invoice-pdf', $data);
        return $pdf->stream('invoice.pdf'); // Code to stream pdf file
        // return $pdf->download('invoice.pdf'); // Code to download pdf file
    }
}
