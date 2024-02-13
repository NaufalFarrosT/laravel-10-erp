<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->sortBy('name');

        return view('user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new User();
        $data->fullname = $request->get('fullname');
        $data->name = $request->get('name');
        $data->dob = $request->get('dob');
        $data->address = $request->get('address');
        $data->gender = $request->get('gender');
        $data->email = $request->get('email');
        $data->password = Hash::make($request->get('password'));
        $data->role_id = $request->get('role_id');
        $data->join_date = $request->get('join_date');
        $data->save();

        return redirect()->route('user.index')->with('Success', 'BERHASIL MENAMBAHKAN DATA USER');;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json(array(
            'msg' => view('user.modal-show', compact('user'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
