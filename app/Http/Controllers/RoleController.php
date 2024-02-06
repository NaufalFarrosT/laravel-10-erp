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
    public function index()
    {
        $roles = DB::select("SELECT R.id, R.name, COUNT(U.role_id) as 'total' FROM roles R LEFT JOIN users U on R.id = U.role_id GROUP BY R.id, R.name");

        return view('role.index', ['roles' => $roles]);
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
            'msg' => $data
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
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
                'msg' => 'Data jabatan berhasil dihapus'
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'kesalahan dalam menghapus data'
            ), 200);
        }
    }
}
