<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $units = Unit::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('unit.index', ['units' => $units, 'table_search' => $search]);
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
        $data = new Unit();
        $data->name = $request->get('name');
        $data->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA UNIT BARU', 'data' => $data
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $unit = Unit::find($id);

        $items = $unit->items;

        return response()->json(array(
            'msg' => view('unit.modal-show', compact('unit'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = Unit::find($id);

        return response()->json(array(
            'msg' => view('unit.modal-edit', compact('unit'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        $unit->name = $request->get('name');
        $unit->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA UNIT'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);

        try {
            $unit->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA UNIT'
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
        $unit = Unit::find($id);

        return response()->json(array(
            'msg' => view('unit.modal-deleteConfirmation', compact('unit'))->render()
        ), 200);
    }
}
