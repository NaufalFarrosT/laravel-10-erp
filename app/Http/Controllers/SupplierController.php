<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $suppliers = Supplier::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('supplier.index', ['suppliers' => $suppliers, 'table_search' => $search]);
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
        $data = new Supplier();
        $data->name = $request->get('name');
        $data->address = $request->get('address');

        $data->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA PEMASOK BARU', 'data' => $data
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        //$items = $supplier->items;

        return response()->json(array(
            'msg' => view('supplier.modal-show', compact('supplier'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);

        return response()->json(array(
            'msg' => view('supplier.modal-edit', compact('supplier'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->name = $request->get('name');
        $supplier->address = $request->get('address');
        $supplier->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA PEMASOK'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        try {
            $supplier->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA PEMASOK'
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
        $supplier = Supplier::find($id);

        return response()->json(array(
            'msg' => view('supplier.modal-deleteConfirmation', compact('supplier'))->render()
        ), 200);
    }
}
