<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        return view('purchase.index', [
            'transactions' => $transactions,
            'date_range' => $date_range,
            'table_search' => $search,
        ]);
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
        //
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
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
