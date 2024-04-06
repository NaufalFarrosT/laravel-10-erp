<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReceive;
use App\Models\ItemReceiveDetail;
use App\Models\ItemWarehouse;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Store Purchase Order
        $purchase_order = new PurchaseOrder();
        $purchase_order->date = $request->get('datePicker');
        $purchase_order->total_price = $request->get('total');
        $purchase_order->supplier_id = $request->get('supplier_id');
        $purchase_order->status = "PROSES";
        $purchase_order->save();

        // Store Purchase Detail
        for ($i = 0; $i < count($request->get('itemId')); $i++) {
            $purchase_detail = new PurchaseDetail();
            $purchase_detail->qty = $request->get('quantity')[$i];
            $purchase_detail->price = intval(str_replace('.', '', $request->get('price')[$i]));
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
        // $item_receive = DB::table("item_receives")
        //     ->join('purchase_details', 'item_receives.purchase_detail_id', '=', 'purchase_details.id')
        //     ->join('purchase_orders', 'purchase_details.purchase_order_id', '=', 'purchase_orders.id')
        //     ->select('item_receives.*')
        //     ->get();

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

    public function createItemReceive($purchase_id)
    {
        $purchase_order = PurchaseOrder::find($purchase_id);
        $warehouses = Warehouse::all();

        $purchase_details = DB::select("SELECT PD.id, I.id as item_id, I.name as item_name, PD.qty-if(sum(IRD.qty) is null, 0, sum(IRD.qty)) as qty, U.name as unit_name from purchase_details PD 
            LEFT JOIN item_receive_details IRD on PD.id = IRD.purchase_detail_id
            INNER JOIN items I on PD.item_id = I.id
            INNER JOIN units U on I.unit_id = U.id
            GROUP BY PD.id, I.id, I.name, PD.qty, U.name;");

        return view(
            'purchase.item_receive',
            [
                'purchase_order' => $purchase_order,
                'purchase_details' => $purchase_details,
                'warehouses' => $warehouses
            ]
        );
    }

    public function storeItemReceive(Request $request)
    {
        // Init variables
        $status_datas = $request->selectedData;
        $qty_datas = $request->qty;
        $purchase_detail_id_datas = $request->purchase_detail_id;
        $warehouse_id = $request->warehouse_id;
        $purchase_order_id = $request->purchase_order_id;

        // Store Item Receive Data
        $item_receive_data = new ItemReceive();
        $item_receive_data->date = $request->datePicker;
        $item_receive_data->warehouse_id = $warehouse_id;
        $item_receive_data->purchase_order_id = $purchase_order_id;
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
        $check_remaining_item_query = DB::select("SELECT sum(helper.qty) as qty from (SELECT PD.id, I.id as item_id, PD.qty-if(sum(IRD.qty) is null, 0, sum(IRD.qty)) as qty from purchase_details PD 
                LEFT JOIN item_receive_details IRD on PD.id = IRD.purchase_detail_id
                INNER JOIN items I on PD.item_id = I.id
                GROUP BY PD.id, I.id, PD.qty) AS helper;");

        // check if all item is recevied or still progress

        if ($check_remaining_item_query[0]->qty == 0) {
            $purchase_order_data = PurchaseOrder::find($purchase_order_id);
            $purchase_order_data->item_receive_status = "SEMUA";
            $purchase_order_data->save();
        }

        return redirect()->route('purchase.show', $request->purchase_order_id);
    }

    public function deleteConfirmationItemReceive($id)
    {
        $data = ItemReceive::find($id);
        $route = "/purchase/item-receive";
        $tableName = "item_receive";

        return response()->json(array(
            'msg' => view('modal.deleteConfirmation', compact('data', 'route', 'tableName'))->render()
        ), 200);
    }

    public function deleteItemReceive($id)
    {
        $itemReceive = ItemReceive::find($id);

        try {
            foreach ($itemReceive->itemReceiveDetails as $ird) {
                $ird->delete();
            }
            $itemReceive->delete();

            $purchase_order = PurchaseOrder::find($itemReceive->purchase_order_id);
            $purchase_order->item_receive_status = "PROSES";
            $purchase_order->save();

            // return redirect()->route('purchase.show', $itemReceive->purchase_order_id);
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA PENERIMAAN BARANG',
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'kesalahan dalam menghapus data' . $id
            ), 200);
        }
    }
}
