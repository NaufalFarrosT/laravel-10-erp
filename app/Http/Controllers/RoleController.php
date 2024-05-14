<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $roles = Role::where('name', 'like', '%' . $search . '%')->withCount('users')->paginate(10);

        return view('role.index', ['roles' => $roles, 'table_search' => $search]);
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
        $data = new Role();
        $data->name = $request->get('name');
        $data->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA JABATAN BARU',
            'data' => $data
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::find($id);

        $users = $role->users;

        return response()->json(array(
            'msg' => view('role.modal-show', compact('role', 'users'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);

        return response()->json(array(
            'msg' => view('role.modal-edit', compact('role'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA JABATAN'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        try {
            $role->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA JABATAN'
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'kesalahan dalam menghapus data'
            ), 200);
        }
    }

    // public function showUserBasedOnRole($id)
    // {
    //     $users = Role::find($id)->with('users')->get();

    //     return response()->json(array(
    //         'msg' => view('role.modal-show', compact('users'))->render()
    //     ), 200);
    // }

    public function deleteConfirmation($id)
    {
        $role = Role::find($id);

        return response()->json(array(
            'msg' => view('role.modal-deleteConfirmation', compact('role'))->render()
        ), 200);
    }
}
