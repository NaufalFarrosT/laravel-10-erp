<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return view('item.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('item.create', ['suppliers' => $suppliers,'units' => $units,'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Item();
        $item->name = $request->get('name');
        $item->price = $request->get('price');
        $item->stock = $request->get('stock');
        $item->unit_id = $request->get('unit_id');
        $item->category_id = $request->get('category_id');
        $item->save();

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
        $suppliers = Supplier::all();

        return view('item.edit', ['item' => $item,'suppliers' => $suppliers,'units' => $units]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = new Item();
        $item->name = $request->get('name');
        $item->price = $request->get('price');
        $item->stock = $request->get('stock');
        $item->supplier_id = $request->get('supplier_id');
        $item->unit_id = $request->get('unit_id');
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
}
