<?php

namespace App\Http\Controllers;

use App\Models\SubAccount;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date_range = $request->input('dateRange');
        $start_date = Carbon::today();
        $end_date = Carbon::today();
        $search =  ($request->get("table_search") == "" ? "" : $request->get("table_search"));

        if ($date_range && strpos($date_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = Carbon::createFromFormat('d-M-Y', $start_date)->startOfDay();
            $end_date = Carbon::createFromFormat('d-M-Y', $end_date)->endOfDay();
        }

        $transactions = Transaction::whereBetween('date', [$start_date, $end_date])
            ->where('information', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('transaction.index', [
            'transactions' => $transactions,
            'date_range' => $date_range,
            'table_search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $request)
    {
        $sub_accounts = SubAccount::all();

        $transaction_type = $request->transaction_type;

        return response()->json(array(
            'data' => view('transaction.modal-create', compact('transaction_type', 'sub_accounts'))->render()
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prefix = 'IE';
        $date = Carbon::now()->format('Ymd');

        // Count total order today
        $total_transaction_today = Transaction::whereDate('created_at', Carbon::today())->count() + 1;

        $transaction_code = sprintf('%s%s-%03d', $prefix, $date, $total_transaction_today);

        $new_transaction = new Transaction();
        $new_transaction->code = $transaction_code;
        $new_transaction->date = $request->get('date');
        $new_transaction->amount = $request->get('amount');
        $new_transaction->information = $request->get('information');
        $new_transaction->transaction_type_id = $request->get('transaction_type_id');
        $new_transaction->sub_account_id = $request->get('sub_account_id');
        $new_transaction->user_id = Auth::id();
        $new_transaction->save();

        $sub_account = SubAccount::find($new_transaction->sub_account_id);

        if ($new_transaction->transaction_type_id == 1) {
            $sub_account->balance = $sub_account->balance + $new_transaction->amount;
        } else {
            $sub_account->balance = $sub_account->balance - $new_transaction->amount;
        }
        $sub_account->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA BARU',
            'data' => $new_transaction,
            'request' => $request,
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $sub_accounts = SubAccount::all();

        return response()->json(array(
            'data' => view('transaction.modal-edit', compact('transaction', 'sub_accounts'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $sub_account = SubAccount::find($transaction->sub_account_id);
        if ($transaction->transaction_type_id == 1) {
            $sub_account->balance = $sub_account->balance - $transaction->amount;
        } else {
            $sub_account->balance = $sub_account->balance + $transaction->amount;
        }
        $sub_account->save();

        $transaction->date = $request->get('date');
        $transaction->amount = $request->get('amount');
        $transaction->information = $request->get('information');
        $transaction->sub_account_id = $request->get('sub_account_id');
        $transaction->save();

        $sub_account = SubAccount::find($transaction->sub_account_id);
        if ($transaction->transaction_type_id == 1) {
            $sub_account->balance = $sub_account->balance + $transaction->amount;
        } else {
            $sub_account->balance = $sub_account->balance - $transaction->amount;
        }
        $sub_account->save();

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA TRANSAKSI'
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        // Retrieve balance on account
        $sub_account = SubAccount::find($transaction->sub_account_id);
        if ($transaction->transaction_type_id == 1) {
            $sub_account->balance = $sub_account->balance - $transaction->amount;
        } else {
            $sub_account->balance = $sub_account->balance + $transaction->amount;
        }
        $sub_account->save();

        try {
            $transaction->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS DATA'
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
        $transaction = Transaction::find($id);

        return response()->json(array(
            'data' => view('transaction.modal-deleteConfirmation', compact('transaction'))->render()
        ), 200);
    }
}
