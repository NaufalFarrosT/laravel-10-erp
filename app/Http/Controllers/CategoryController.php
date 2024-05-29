<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $categories = Category::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('category.index', ['categories' => $categories, 'table_search' => $search]);
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
        $category = new Category();
        $category->name = $request->get('name');
        $category->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA KATEGORI BARU', 'category' => $category
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        $items = $category->items;

        return response()->json(array(
            'data' => view('category.modal-show', compact('category','items'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return response()->json(array(
            'msg' => view('category.modal-edit', compact('category'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA KATEGORI'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            $category->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA KATEGORI'
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
        $category = Category::find($id);

        return response()->json(array(
            'msg' => view('category.modal-deleteConfirmation', compact('category'))->render()
        ), 200);
    }
}
