<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between">
            <h3 class="card-title">Data Pembayaran</h3>
            <div id="purchase_payment_action" class="p-0 m-0">
                @if ($purchase_order->payment_status != 'Lunas')
                    <button type="button" id="btn_add_purchase_payment" style="width: fit-content;" class="btn btn-sm btn-success"
                        onclick="createPayment({{ $purchase_order->id }})">Tambah
                        Pembayaran Barang</button>
                @endif
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body pb-0">
        <div class="row table-responsive p-0">
            <table id="payment-info" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Jumlah</th>
                        <th>Akun</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_order->payments as $payment)
                        <tr id="tr_purchase_payment_{{ $payment->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td id="td_purchase_payment_date_{{ $payment->id }}">{{ $payment->date }}</td>
                            <td id="td_purchase_payment_code_{{ $payment->id }}">{{ $payment->code }}</td>
                            <td id="td_purchase_payment_amount_{{ $payment->id }}">
                                @php
                                    echo 'Rp ' . number_format($payment->amount, 0, ',', '.');
                                @endphp
                            </td>
                            <td id="td_purchase_payment_sub_account_{{ $payment->id }}">
                                {{ $payment->sub_account->name }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button onclick="editPaymentData({{ $payment->id }})" class="btn btn-sm btn-warning mr-2"><i
                                            class="fas fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteConfirmationPurchasePayment({{ $payment->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
    </div>
    <!-- /.card-footer -->
</div>
