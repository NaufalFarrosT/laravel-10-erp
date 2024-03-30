<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase_orders = PurchaseOrder::all();

        return view('purchase.index', ['purchase_orders' => $purchase_orders]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($purchase_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_id);

        return view(
            'purchase.purchase_order.detail',
            ['purchase_order' => $purchase_order]
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

    public function storePurchaseDetail(Request $request)
    {
        // dd($request);
        $purchase_order = new PurchaseOrder();
        $purchase_order->date = $request->get('datePicker');
        $purchase_order->total_price = $request->get('total');
        $purchase_order->supplier_id = $request->get('supplier_id');
        $purchase_order->save();
        // dd($purchase_order->id);

        for ($i = 0; $i < count($request->get('itemId')); $i++) {
            $data = new PurchaseDetail();
            $data->qty = $request->get('quantity')[$i];
            $data->price = intval(str_replace('.', '', $request->get('price')[$i]));
            $data->discount = intval(str_replace('.', '', $request->get('discount')[$i]));
            $data->total_price = $request->get('total_price_per_item')[$i];
            $data->item_id = $request->get('itemId')[$i];
            $data->purchase_order_id = $purchase_order->id;
            $data->save();
        }

        return redirect()->route('purchase.show', $purchase_order->id);
    }

    public function createItemReceive($purchase_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_id);

        return view(
            'purchase.item_receive',
            ['purchase_order' => $purchase_order]
        );
    }
}
