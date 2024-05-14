<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $warehouses = Warehouse::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('warehouse.index', ['warehouses' => $warehouses, 'table_search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_warehouse = new Warehouse();
        $new_warehouse->name = $request->get('warehouse_name');
        $new_warehouse->address = $request->input('address', null);
        $new_warehouse->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN GUDANG BARU', 'new_warehouse' => $new_warehouse
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warehouse = Warehouse::find($id);

        return response()->json(array(
            'msg' => view('warehouse.modal-edit', compact('warehouse'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->name = $request->get('warehouse_name');
        $warehouse->address = $request->input('warehouse_address', null);
        $warehouse->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA GUDANG'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($warehouse_id)
    {
        $warehouse = Warehouse::find($warehouse_id);

        try {
            $warehouse->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA GUDANG'
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'kesalahan dalam menghapus data'
            ), 200);
        }
    }

    public function deleteConfirmation($id)
    {
        $warehouse = Warehouse::find($id);

        return response()->json(array(
            'msg' => view('warehouse.modal-deleteConfirmation', compact('warehouse'))->render()
        ), 200);
    }
}
