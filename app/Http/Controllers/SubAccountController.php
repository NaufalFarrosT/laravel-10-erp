<?php

namespace App\Http\Controllers;

use App\Models\SubAccount;
use Illuminate\Http\Request;

class SubAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        $sub_accounts = SubAccount::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('account.index', ["sub_accounts" => $sub_accounts, 'table_search' => $search]);
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
        $account = new SubAccount();
        $account->name = $request->get('account_name');
        $account->balance = 0;
        $account->account_sub_category_id = 1;
        $account->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA AKUN', 'account' => $account
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubAccount $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $account = SubAccount::find($id);

        return response()->json(array(
            'msg' => view('account.modal-edit', compact('account'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = SubAccount::find($id);
        $account->name = $request->get('name');
        $account->balance = $request->get('balance');
        $account->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA AKUN'
        ), 200);
    }

    public function deleteConfirmation($id)
    {
        $account = SubAccount::find($id);

        return response()->json(array(
            'msg' => view('account.modal-deleteConfirmation', compact('account'))->render()
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = SubAccount::find($id);

        try {
            $account->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA AKUN'
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'kesalahan dalam menghapus data'
            ), 200);
        }
    }
}
