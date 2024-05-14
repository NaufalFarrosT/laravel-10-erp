<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between">
            <h3 class="card-title">Data Pembayaran</h3>
            <div id="sale_payment_action" class="p-0 m-0">
                @if ($sale_order->payment_status != 'Lunas')
                    <button type="button" style="width: fit-content;" class="btn btn-sm btn-success"
                        onclick="createPayment({{ $sale_order->id }})">Tambah
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
                        <th>Jumlah</th>
                        <th>Akun</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale_order->payments as $payment)
                        <tr id="tr_sale_payment_{{ $payment->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td id="td_name_{{ $payment->id }}">{{ $payment->date }}</td>
                            <td>
                                @php
                                    echo 'Rp ' . number_format($payment->amount, 0, ',', '.');
                                @endphp
                            </td>
                            <td>
                                {{ $payment->sub_account->name }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="" class="btn btn-sm btn-warning mr-2"><i
                                            class="fas fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteConfirmationSalePayment({{ $payment->id }})">
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
