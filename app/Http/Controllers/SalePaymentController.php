<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use App\Models\SalePayment;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sale_order = SaleOrder::find($request->sale_order_id);

        $sub_accounts = SubAccount::all();

        $sale_payment = SalePayment::where('sale_order_id', $sale_order->id)->get();

        foreach($sale_payment as $sp){
            $sale_order->total_price -= $sp->amount;
        }

        return response()->json(array(
            'msg' => view('sale.payment.modal-createPayment', compact('sale_order', 'sub_accounts'))->render()
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale_order_id = $request->po_id;

        $new_sale_payment = new SalePayment();
        $new_sale_payment->date = $request->date;
        $new_sale_payment->amount = $request->amount;
        $new_sale_payment->sub_account_id = $request->account;
        $new_sale_payment->sale_order_id = $sale_order_id;
        $new_sale_payment->user_id = Auth::id();
        $new_sale_payment->save();

        // Subtract account balance
        $sub_account = SubAccount::find($new_sale_payment->sub_account_id);
        $sub_account->balance = $sub_account->balance + $new_sale_payment->amount;

        $sub_account->save();

        $sale_order = saleOrder::find($sale_order_id);
        $total_payment = 0;
        foreach ($sale_order->payments as $payment) {
            $total_payment += $payment->amount;
        }

        if ($sale_order->total_price == $total_payment) {
            $sale_order->payment_status = "Lunas";
            $sale_order->status = "Selesai";
        } else {
            $sale_order->payment_status = "Sebagian";
        }
        $sale_order->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA PEMBAYARAN',
            'data' => $new_sale_payment,
            'payment_status' => $sale_order->payment_status
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalePayment $salePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalePayment $salePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalePayment $salePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale_payment = SalePayment::find($id);

        try {
            // Retrieve balance on account
            $sub_account = SubAccount::find($sale_payment->sub_account_id);
            $sub_account->balance = $sub_account->balance - $sale_payment->amount;
            $sub_account->save();

            $sale_order = saleOrder::find($sale_payment->sale_order_id);
            $sale_order->payment_status = "Belum Lunas";
            $sale_order->status = "Proses";
            $sale_order->save();

            $sale_payment->delete();
            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS PEMBARAYAN PENJUALAN'
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
        $data = SalePayment::find($id);
        $route = "/sale/sale-payment";
        $table_name = "sale_payment";

        return response()->json(array(
            'msg' => view('sale.payment.modal-deleteConfirmation', compact('data', 'route', 'table_name'))->render()
        ), 200);
    }
}
