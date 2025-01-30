<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $stores = Store::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('store.index', ['stores' => $stores, 'table_search' => $search]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $new_store = new Store();
        $new_store->name = $request->get('store_name');
        $new_store->address = $request->input('store_address', null);
        $new_store->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN GUDANG BARU',
            'new_store' => $new_store
        ), 200);
    }

    public function show(Store $store)
    {
        //
    }

    public function edit($id)
    {
        $store = Store::find($id);

        return response()->json(array(
            'modal' => view('store.modal-edit', compact('store'))->render()
        ), 200);
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        $store->name = $request->get('store_name');
        $store->address = $request->input('store_address', null);
        $store->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA GUDANG'
        ), 200);
    }

    public function destroy($store_id)
    {
        $store = Store::find($store_id);

        try {
            $store->delete();
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
        $store = Store::find($id);

        return response()->json(array(
            'msg' => view('store.modal-deleteConfirmation', compact('store'))->render()
        ), 200);
    }
}
