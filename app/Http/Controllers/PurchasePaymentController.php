<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\PurchaseOrder;
use App\Models\PurchasePayment;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasePaymentController extends Controller
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
        $purchase_order = PurchaseOrder::find($request->purchase_order_id);

        $sub_accounts = SubAccount::all();

        $purchase_payment = PurchasePayment::where('purchase_order_id', $purchase_order->id)->get();

        foreach ($purchase_payment as $pp) {
            $purchase_order->total_price -= $pp->amount;
        }

        return response()->json(array(
            'msg' => view('purchase.payment.modal-createPayment', compact('purchase_order', 'sub_accounts'))->render()
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $purchase_order_id = $request->po_id;
        $purchase_order = PurchaseOrder::find($purchase_order_id);

        $prefix = 'PP';
        $countTotalPurchasePayment = PurchasePayment::where('purchase_order_id', $purchase_order_id)->count() + 1;

        $pp_code = sprintf('%s-%s-%02d', $purchase_order->code, $prefix, $countTotalPurchasePayment);

        $new_purchase_payment = new PurchasePayment();
        $new_purchase_payment->code = $pp_code;
        $new_purchase_payment->date = $request->date;
        $new_purchase_payment->amount = $request->amount;
        $new_purchase_payment->sub_account_id = $request->account;
        $new_purchase_payment->purchase_order_id = $purchase_order_id;
        $new_purchase_payment->user_id = Auth::id();
        $new_purchase_payment->save();

        // Subtract account balance
        $sub_account = SubAccount::find($new_purchase_payment->sub_account_id);
        $sub_account->balance = $sub_account->balance - $new_purchase_payment->amount;

        $sub_account->save();

        $purchase_order_after_check = $this->checkPaymentStatus($purchase_order);

        // $total_payment = 0;
        // foreach ($purchase_order->payments as $payment) {
        //     $total_payment += $payment->amount;
        // }

        // if ($purchase_order->total_price == $total_payment) {
        //     $purchase_order->payment_status = "Lunas";
        //     $purchase_order->status = "Selesai";
        // } else {
        //     $purchase_order->payment_status = "Sebagian";
        // }
        // $purchase_order->save();

        return response()->json(array(
            'msg' => 'BERHASIL MENAMBAHKAN DATA PEMBAYARAN',
            'data' => $new_purchase_payment,
            'payment_status' => $purchase_order_after_check->payment_status
        ), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchase_payment = PurchasePayment::find($id);
        $sub_accounts = SubAccount::all();

        return response()->json(array(
            'data' => view('purchase.payment.modal-edit', compact('purchase_payment', 'sub_accounts'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // retrieve balance, then substract it with updated payment amount
        $purchase_payment = PurchasePayment::find($id);
        $sub_account = SubAccount::find($purchase_payment->sub_account_id);
        $sub_account->balance = $sub_account->balance + $purchase_payment->amount;
        $sub_account->save();

        $purchase_payment->date = $request->get('date');
        $purchase_payment->amount = $request->get('amount');
        $purchase_payment->sub_account_id = $request->get('sub_account_id');
        $purchase_payment->save();

        $sub_account = SubAccount::find($purchase_payment->sub_account_id);
        $sub_account->balance = $sub_account->balance - $purchase_payment->amount;
        $sub_account->save();

        $purchase_order = PurchaseOrder::find($purchase_payment->purchase_order_id);
        $purchase_order_after_check = $this->checkPaymentStatus($purchase_order);

        return response()->json(array(
            'msg' => 'BERHASIL MEMPERBARUI DATA PEMBAYARAN PEMBELIAN ITEM',
            'payment_status' => $purchase_order_after_check->payment_status
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchase_payment = PurchasePayment::find($id);

        try {
            // Retrieve balance on account
            $sub_account = SubAccount::find($purchase_payment->sub_account_id);
            $sub_account->balance = $sub_account->balance + $purchase_payment->amount;
            $sub_account->save();

            $purchase_order = PurchaseOrder::find($purchase_payment->purchase_order_id);
            // $purchase_order->payment_status = "Belum Lunas";
            // $purchase_order->status = "Proses";
            // $purchase_order->save();

            $purchase_payment->delete();

            $this->checkPaymentStatus($purchase_order);

            return response()->json(array(
                'status' => 'Success',
                'msg' => 'BERHASIL MENGHAPUS PEMBARAYAN PEMBELIAN'
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
        $data = PurchasePayment::find($id);
        $route = "/purchase/purchase-payment";
        $table_name = "purchase_payment";

        return response()->json(array(
            'msg' => view('purchase.payment.modal-deleteConfirmation', compact('data', 'route', 'table_name'))->render()
        ), 200);
    }

    public function checkPaymentStatus($purchase_order)
    {
        $total_payment = 0;
        foreach ($purchase_order->payments as $payment) {
            $total_payment += $payment->amount;
        }

        if ($total_payment == $purchase_order->total_price) {
            $purchase_order->payment_status = "Lunas";
            $purchase_order->status = "Selesai";
        } else {
            $purchase_order->status = "Proses";

            if ($total_payment > 0) {
                $purchase_order->payment_status = "Sebagian";
            } else {
                $purchase_order->payment_status = "Belum Bayar";
            }
        }

        $purchase_order->save();

        return $purchase_order;
    }
}
