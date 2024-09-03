<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReceive;
use App\Models\ItemReceiveDetail;
use App\Models\ItemWarehouse;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date_range = $request->input('dateRange');
        $start_date = Carbon::today();
        $end_date = Carbon::today();
        $po_status = ($request->get("po_status") == "All" ? "" : $request->get("po_status"));
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        if ($date_range && strpos($date_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = Carbon::createFromFormat('d-M-Y', $start_date)->startOfDay();
            $end_date = Carbon::createFromFormat('d-M-Y', $end_date)->endOfDay();
        }

        if ($po_status != "") {
            $purchase_orders = PurchaseOrder::whereBetween('date', [$start_date, $end_date])
                ->where('status', $po_status)
                ->where('id', 'like', '%' . $search . '%')
                ->paginate(10);
        } else {
            $purchase_orders = PurchaseOrder::whereBetween('date', [$start_date, $end_date])
                ->where('id', 'like', '%' . $search . '%')
                ->paginate(10);
        }

        return view('purchase.index', [
            'purchase_orders' => $purchase_orders,
            'date_range' => $date_range,
            'po_status' => $po_status,
            'table_search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase.purchase_order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $prefix = 'PO';
        $date = Carbon::now()->format('Ymd');

        // Count total order today
        $totalOrdersToday = PurchaseOrder::whereDate('created_at', Carbon::today())->count() + 1;

        $po_code = sprintf('%s%s-%03d', $prefix, $date, $totalOrdersToday);

        $get_supplier = Supplier::where('name', $request->get('supplier_search'))->get(); // Get data supplier if exist

        // Store Purchase Order
        $purchase_order = new PurchaseOrder();
        $purchase_order->code = $po_code;
        $purchase_order->date = $request->get('datePicker');
        $purchase_order->total_price = $request->get('total');
        $purchase_order->supplier_id = ($get_supplier->count() == 0)
            ? Supplier::create(['name' => $request->supplier_search])->id
            : $get_supplier[0]->id;
        $purchase_order->status = "PROSES";
        $purchase_order->item_receive_status = "Belum Diterima";
        $purchase_order->payment_status = "Belum Bayar";
        $purchase_order->user_id = Auth::id();
        $purchase_order->save();

        // Store Purchase Detail
        for ($i = 0; $i < count($request->get('itemId')); $i++) {
            $purchase_detail = new PurchaseDetail();
            $purchase_detail->qty = $request->get('quantity')[$i];
            $purchase_detail->price = intval(str_replace(',', '', $request->get('price')[$i]));
            $purchase_detail->discount = intval(str_replace('.', '', $request->get('discount')[$i]));
            $purchase_detail->total_price = $request->get('total_price_per_item')[$i];
            $purchase_detail->item_id = $request->get('itemId')[$i];
            $purchase_detail->purchase_order_id = $purchase_order->id;
            $purchase_detail->save();
        }

        return redirect()->route('purchase.show', $purchase_order->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($purchase_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_id);

        return view(
            'purchase.purchase_order.detail',
            [
                'purchase_order' => $purchase_order,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function autoCompleteItem(Request $request)
    {
        $data = Item::select("items.id", DB::raw("CONCAT( items.name, ' - ', units.name) as value"), "items.selling_price", "items.stock")
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->where('items.name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();
        // $data = Item::select("items.id", DB::raw("CONCAT(items.code, ' - ', items.name, ' (', units.name, ')') as value"), "items.price", "items.stock")
        //     ->join('units', 'items.unit_id', '=', 'units.id')
        //     ->where('items.name', 'LIKE', '%' . $request->get('search') . '%')
        //     ->get();

        return response()->json($data);
    }

    public function autoCompleteSupplier(Request $request)
    {
        $data = Supplier::select("suppliers.id", "suppliers.name", DB::raw("CONCAT(suppliers.id, ' - ', suppliers.name) as value"))
            ->where('suppliers.name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();

        // $data = Supplier::select("id", "name as value")
        //     ->where('name', 'LIKE', '%' . $request->get('search') . '%')
        //     ->get();

        return response()->json($data);
    }

    public function print_table()
    {
        $purchase_orders = PurchaseOrder::all();

        $data = [
            'purchase_orders' => $purchase_orders,
        ];

        $pdf = PDF::loadview('pegawai_pdf', ['purchase_orders' => $purchase_orders]);
        return $pdf->stream();
    }

    public function print_invoice($purchase_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_id);
        $purchase_order->date = Carbon::parse($purchase_order->date)->format('d-m-Y');

        $purchase_payment = PurchasePayment::where('purchase_order_id', $purchase_id)->get();
        $total_purchase_payment = 0;

        foreach ($purchase_payment as $sp) {
            $total_purchase_payment += $sp->amount;
        }

        $data = [
            'purchase_order' => $purchase_order,
            'total_purchase_payment' => $total_purchase_payment,
        ];

        $pdf = Pdf::loadview('purchase.invoice-pdf', $data);
        return $pdf->stream('invoice.pdf'); // Code to stream pdf file
        // return $pdf->download('invoice.pdf'); // Code to download pdf file
    }
}
