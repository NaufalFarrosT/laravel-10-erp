<?php

namespace App\Http\Controllers;

use App\Imports\ItemImport;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Store;
use App\Models\StoreItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $items = Item::where('name', 'like', '%' . $search . '%')->get()->sortBy('name');

        return view('item.index', ['items' => $items, 'table_search' => $search]);
    }

    public function create()
    {
        $units = Unit::all();
        $categories = Category::all();

        return view('item.create', ['units' => $units, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $item = new Item();
        $item->name = $request->get('name');
        $item->selling_price = $request->get('selling_price');
        $item->buying_price = $request->get('buying_price');
        $item->profit = $item->selling_price - $item->buying_price;
        $item->stock = 0;
        $item->item_capital = 0;
        $item->unit_id = $request->get('unit_id');
        $item->category_id = $request->get('category_id');
        $item->save();

        // Create Item Data on each Store
        $stores = Store::all();
        foreach ($stores as $store) {
            $store_item = new StoreItem();
            $store_item->item_id = $item->id;
            $store_item->store_id = $store->id;
            $store_item->stock = 0;

            $store_item->save();
        }

        return redirect()->route('item.index')->with('Success', 'BERHASIL MENAMBAHKAN DATA ITEM');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::find($id);

        return response()->json(array(
            'msg' => view('item.modal-show', compact('item'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::find($id);

        $units = Unit::all();
        $categories = Category::all();

        return view('item.edit', ['item' => $item, 'units' => $units, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->name = $request->get('name');
        $item->selling_price = $request->get('selling_price');
        $item->buying_price = $request->get('buying_price');
        $item->profit = $item->selling_price - $item->buying_price;
        $item->stock = $request->get('stock');
        $item->unit_id = $request->get('unit_id');
        $item->category_id = $request->get('category_id');
        $item->save();

        return redirect()->route('item.index')->with('Success', 'BERHASIL MEMPERBARUI DATA ITEM');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);

        try {
            $item->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA ITEM'
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
        $item = Item::find($id);

        return response()->json(array(
            'msg' => view('item.modal-deleteConfirmation', compact('item'))->render()
        ), 200);
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new ItemImport, $request->file('file'));

        return redirect()->back()->with('success', 'Item imported successfully.');
    }
}
