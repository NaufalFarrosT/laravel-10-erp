<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReceive;
use App\Models\ItemReceiveDetail;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($purchase_order_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_order_id);
        $warehouses = Warehouse::all();

        $purchase_details = PurchaseDetail::all()->where('purchase_order_id', $purchase_order_id);
        $item_receive = ItemReceive::all()->where('purchase_order_id', $purchase_order_id);

        // Looping Tiap Detil Pembelian
        // Cek semua penerimaan barang
        // Kurangi jumlah tiap item di detil pembelian barang dengan yang sudah diterima
        foreach ($purchase_details as $pd) {
            foreach ($item_receive as $ir) {
                foreach ($ir->itemReceiveDetails as $ird) {
                    if ($pd->id == $ird->purchase_detail_id) {
                        $pd->qty = $pd->qty - $ird->qty;
                    }
                }
            }
        }

        return view(
            'purchase.item_receive.create',
            [
                'purchase_order' => $purchase_order,
                'purchase_details' => $purchase_details,
                'warehouses' => $warehouses
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Init variables
        $status_datas = $request->selectedData;
        $qty_datas = $request->qty;
        $purchase_detail_id_datas = $request->purchase_detail_id;
        $warehouse_id = $request->warehouse_id;
        $purchase_order = PurchaseOrder::find($request->purchase_order_id);

        // Store Item Receive Data
        $prefix = 'IR';
        $countTotalItemReceive = ItemReceive::where('purchase_order_id', $purchase_order->id)->count() + 1;

        $ir_code = sprintf('%s-%s-%02d', $purchase_order->code, $prefix, $countTotalItemReceive);

        $item_receive_data = new ItemReceive();
        $item_receive_data->code = $ir_code;
        $item_receive_data->date = $request->datePicker;
        $item_receive_data->warehouse_id = $warehouse_id;
        $item_receive_data->purchase_order_id = $purchase_order->id;
        $item_receive_data->save();

        // Store Item Receive Detail Data
        $data_length = count($status_datas);
        for ($idx = 0; $idx < $data_length; $idx++) {
            if ($status_datas[$idx] == "true") {
                $item_receive_detail_data = new ItemReceiveDetail();

                $item_receive_detail_data->qty = $qty_datas[$idx];
                $item_receive_detail_data->item_receive_id = $item_receive_data->id;
                $item_receive_detail_data->purchase_detail_id = $purchase_detail_id_datas[$idx];

                $item_receive_detail_data->save();

                // Update and Increase Item Stock
                $pd = PurchaseDetail::find($purchase_detail_id_datas[$idx]);
                $item = Item::find($pd->item_id);
                $item->stock = $item->stock + $qty_datas[$idx];
                $item->save();

                // Start Update and Increase Item Stock in Warehouse
                $warehouse_item = WarehouseItem::where('item_id', $pd->item_id)->where('warehouse_id', $warehouse_id)->first();

                // Check if warehouse item already exist or not
                // If not exist, create new warehouse item
                if ($warehouse_item == null) {
                    $warehouse_item = new WarehouseItem();
                    $warehouse_item->stock = $qty_datas[$idx];
                    $warehouse_item->item_id = $pd->item_id;
                    $warehouse_item->warehouse_id = $warehouse_id;
                } else {
                    $warehouse_item->stock = $warehouse_item->stock + $qty_datas[$idx];
                }
                $warehouse_item->save();
                // END Update and Increase Item Stock in Warehouse
            }
        }

        // Query to check remaining Item from purchase order
        // check if all item is received or still progress
        $check_remaining_item_query = DB::select("SELECT IRD.purchase_detail_id , PD.qty, SUM(IRD.qty) as 'item_receive_qty' FROM item_receive_details IRD INNER JOIN purchase_details PD on IRD.purchase_detail_id = PD.id INNER JOIN
        item_receives IR on IR.id = IRD.item_receive_id WHERE IRD.deleted_at is null AND IR.purchase_order_id=" . $purchase_order->id . " GROUP BY IRD.purchase_detail_id, PD.qty;");

        $item_receive_status = true;
        foreach ($check_remaining_item_query as $item) {
            if ($item->qty != $item->item_receive_qty) {
                $item_receive_status = false;
            }
        }

        if ($item_receive_status == true) {
            $purchase_order->item_receive_status = "Diterima";

            if ($purchase_order->payment_status == "Lunas") {
                $purchase_order->status = "Selesai";
            }

            $purchase_order->save();
        } else {
            $purchase_order->item_receive_status = "Diterima Sebagian";
        }

        return redirect()->route('purchase.show', $request->purchase_order_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemReceive $itemReceive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item_receive = ItemReceive::find($id);
        $purchase_order = PurchaseOrder::find($item_receive->purchase_order_id);
        $warehouses = Warehouse::all();

        $purchase_details = PurchaseDetail::all()->where('purchase_order_id', $purchase_order->id);

        return view(
            'purchase.item_receive.edit',
            [
                'item_receive' => $item_receive,
                'purchase_order' => $purchase_order,
                'purchase_details' => $purchase_details,
                'warehouses' => $warehouses
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemReceive $itemReceive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item_receive = ItemReceive::find($id);
        $purchase_order_id = $item_receive->purchase_order_id;

        try {
            foreach ($item_receive->itemReceiveDetails as $ird) {
                $warehouse = Warehouse::find($item_receive->warehouse_id);
                $item = $ird->purchaseDetail->item;
                $item->stock = $item->stock - $ird->qty;
                $item->save();

                $warehouse_item = WarehouseItem::where('item_id', $item->id)
                    ->where('warehouse_id', $warehouse->id)->decrement('stock', $ird->qty);

                // $warehouse_item->stock = $warehouse_item->stock - $ird->qty;
                // $warehouse_item->save();

                $ird->delete();
            }
            $item_receive->delete();

            // Check if item receive from this purchase order id still exist update receive status to "Diterima sebagian"
            // If not update status to "Belum Diterima"
            $count_item_receive_query = DB::select("Select count(*) from item_receives where purchase_order_id=" . $purchase_order_id);

            $purchase_order = PurchaseOrder::find($purchase_order_id);
            $count_item_receive_query !== 0
                ? $purchase_order->item_receive_status = "Diterima Sebagian"
                : $purchase_order->item_receive_status = "Belum Diterima";
            $purchase_order->status = "Proses";
            $purchase_order->save();

            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA PENERIMAAN BARANG',
                'id_item_receive' => $id,
                'data_purchase' => $purchase_order
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => $e
            ), 400);
        }
    }

    public function deleteConfirmation($id)
    {
        $data = ItemReceive::find($id);
        $route = "/purchase/item-receive";
        $table_name = "item_receive";

        return response()->json(array(
            'msg' => view('purchase.item_receive.modal-deleteConfirmation', compact('data', 'route', 'table_name'))->render()
        ), 200);
    }
}
