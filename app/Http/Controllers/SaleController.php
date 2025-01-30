<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\SaleDetail;
use App\Models\SaleOrder;
use App\Models\SalePayment;
use App\Models\StoreItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
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

    public function create()
    {
        return view('sale.create');
    }

    public function store(Request $request)
    {
        $prefix = 'SO';
        $date = Carbon::now()->format('Ymd');

        // Count total order today
        $totalOrdersToday = SaleOrder::whereDate('created_at', Carbon::today())->count() + 1;

        $so_code = sprintf('%s%s-%03d', $prefix, $date, $totalOrdersToday);

        $get_customer = Customer::where('name', $request->customer_name)->get(); // Get data custoemr if exist

        // Store Sale Order
        $sale_order = new SaleOrder();
        $sale_order->code = $so_code;
        $sale_order->date = $request->get('datePicker');
        $sale_order->total_price = $request->get('total');
        $sale_order->status = "PROSES";
        $sale_order->payment_status = "Belum Bayar";
        $sale_order->customer_id = ($get_customer->count() == 0)
            ? 1
            : Customer::create(['name' => $request->customer_name])->id;
        $sale_order->user_id = Auth::id();
        $sale_order->save();

        // Store Sale Detail
        for ($i = 0; $i < count($request->get('itemId')); $i++) {
            $item = Item::find($request->get('itemId'))[$i];
            $quantity = $request->get('quantity')[$i];

            $sale_detail = new SaleDetail();
            $sale_detail->qty = $quantity;
            $sale_detail->selling_price = intval(str_replace('.', '', $request->get('price')[$i]));
            $sale_detail->buying_price = $item->buying_price;
            $sale_detail->profit = $item->profit * $quantity;
            $sale_detail->discount = intval(str_replace('.', '', $request->get('discount')[$i]));
            $sale_detail->total_price = $request->get('total_price_per_item')[$i];
            $sale_detail->item_id = $request->get('itemId')[$i];
            $sale_detail->sale_order_id = $sale_order->id;
            $sale_detail->save();

            // Update Stock on Store
            $store_item = StoreItem::find($request->get('storeItemId')[$i]);
            $store_item->stock = $store_item->stock - $sale_detail->qty;
            $store_item->save();

            // Update master item stock
            $item = Item::find($sale_detail->item_id);
            $item->stock = $item->stock - $sale_detail->qty;
            $item->save();
        }

        return redirect()->route('sale.show', $sale_order->id);
    }

    public function show($sale_id)
    {
        $sale_order = SaleOrder::find($sale_id);

        // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$serverKey = "SB-Mid-server-RNe_fTWtSw6Y9ebljEoaR7_m";
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 15000,
            )
        );

        $snap_token = \Midtrans\Snap::getSnapToken($params);

        return view(
            'sale.detail',
            [
                'sale_order' => $sale_order,
                'snap_token' => $snap_token,
            ]
        );
    }

    public function edit(SaleOrder $salesOrder)
    {
        //
    }

    public function update(Request $request, SaleOrder $salesOrder)
    {
        //
    }

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
        $data = Item::select("store_items.id as store_item_id", "stores.name", "items.id", DB::raw("CONCAT(stores.name,' - ',items.name, ' - ', store_items.stock,' ' , units.name) as value"), "items.selling_price", "store_items.stock")
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->join('store_items', 'store_items.item_id', '=', 'items.id')
            ->join('stores', 'stores.id', '=', 'store_items.store_id')
            ->where('items.stock', '>', 0)
            ->where('items.name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();

        return response()->json($data);
    }

    public function print_invoice($sale_id)
    {
        $sale_order = SaleOrder::find($sale_id);
        $sale_order->date = Carbon::parse($sale_order->date)->format('d-m-Y');

        $sale_payment = SalePayment::where('sale_order_id', $sale_id)->get();
        $total_sale_payment = 0;

        foreach ($sale_payment as $sp) {
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
