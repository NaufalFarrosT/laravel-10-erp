@extends('layouts.adminlte')
@section('content-header')
    <li class="nav-item d-none d-sm-inline-block">
        <h3>Detil Penjualan</h3>
    </li>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-sm-2">
                    <a href="{{ Route('sale.index') }}" class="btn btn-m btn-default ml-2"> Kembali</a>
                </div>
                <div class="col-sm-2 text-right">
                    <a href="{{ route('purchase.create') }}" class="btn btn-m btn-primary">
                        <i class="fas fa-print"></i>
                        Cetak Nota
                    </a>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-content">

                        </div>
                    </div>
                </div>

                <input type="hidden" id="sale_order_id" value={{ $sale_order->id ?? 0 }}>

                <!-- form start -->

                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Penjualan</h3>
                    </div>

                    <div class="card-body pt-0 pb-0">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-sm-4">
                                <div class="form-group col-sm-8 p-0">
                                    <label class="col-form-label">Pelanggan</label>
                                    <input id="customer_search" type="text" class="form-control"
                                        value="{{ $sale_order->customer->name }}" name="customer_name" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group col-sm-6 p-0">
                                    <label class="col-form-label">Tanggal</label>
                                    <input class="form-control form-control-inline input-medium date-picker" size="16"
                                        type="text"
                                        value="{{ \Carbon\Carbon::parse($sale_order->date)->format('d-m-Y') }}"
                                        id="datePicker" name="datePicker" readonly/>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col col-form-label">TOTAL</label>
                                    <label id="displayTotal" name="displayTotal" class="bold"
                                        style="margin-left: 10px;font-size: large;">
                                        {{ 'Rp ' . number_format($sale_order->total_price, 0, ',', '.') }}
                                    </label>
                                    <input type="hidden" id="total" name="total">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-size: 24px;">Detil Penjualan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <label for="supplier" class="col-sm-1 col-form-label">Pelanggan</label>
                            <div class="col-sm-3">
                                <label class='form-control' @readonly(true)>
                                    {{ $sale_order->customer->name }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label">Tanggal</label>
                            <div class="col-sm-2">
                                <input type='text' class='form-control'
                                    value='{{ \Carbon\Carbon::parse($sale_order->date)->format('d-m-Y') }}' readonly>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="col-sm-1 col-form-label p-0">Total </label>
                            <label id="displayTotal" name="displayTotal" class="bold col-sm-3 m-0 p-0"
                                style="margin-left: 10px;font-size: large;">
                                @php
                                    echo 'Rp ' . number_format($sale_order->total_price, 0, ',', '.');
                                @endphp
                            </label>
                        </div>
                    </div>
                </div> --}}

                <!-- Card Penerimaan Barang & Pembayaran -->
                <div class="container-fluid m-0 w-100">
                    <div class="row w-100">
                        <!-- Pembayaran Barang -->
                        <div class="col-sm-6">
                            @include('sale.payment.table')
                        </div>
                        <!-- Penerimaan Barang -->
                        <div class="col-sm-6">
                            {{-- @include('sale.item_send.table') --}}
                        </div>


                    </div>
                </div>
                <!-- End Card Penerimaan Barang & Pembayaran -->


                <!-- Card <i class="fas fa-eye"></i> Penjualan -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Penjualan Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive p-0">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Potongan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale_order->sale_details as $sd)
                                        <tr id="tr_{{ $sd->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_name_{{ $sd->id }}">{{ $sd->item->name }}</td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($sd->price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $sd->qty }} {{ $sd->item->unit->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($sd->discount, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($sd->total_price, 0, ',', '.');
                                                @endphp
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
                <!-- End Card <i class="fas fa-eye"></i> Penjualan -->
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        // Payment
        // Trigger modal create payment after click payment
        function createPayment(sale_order_id) {
            console.log(sale_order_id)
            $.ajax({
                type: "GET",
                url: "{{ route('sale-payment.create') }}",
                data: {
                    sale_order_id: sale_order_id,
                },
                success: function(response) {
                    $("#modal-content").html(response.msg);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    // Handle error response
                    if (xhr.status == 404) {
                        alert('Resource not found');
                    } else if (xhr.status == 500) {
                        alert('Internal Server Error');
                    } else {
                        alert('An error occurred: ' + xhr.statusText);
                    }
                }
            });
        }

        function storePaymentData() {
            var payment_date = $("#datePicker").val();
            var payment_amount = $("#payment_amount").val();
            var sub_account_name = $("#account_id option:selected").text();
            var account_id = $("#account_id").val();
            var sale_order_id = $('#sale_order_id').val();

            var payment_amount_integer_format = payment_amount.replace(/Rp\.|\./g, '').trim();
            var numberOfRow = $("#payment-info tr").length - 0;

            $.ajax({
                type: "POST",
                url: `{{ route('sale-payment.store') }}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    date: payment_date,
                    amount: payment_amount_integer_format,
                    account: account_id,
                    po_id: sale_order_id,
                },
                success: function(response) {
                    console.log(response.data);
                    toastr.success(response.msg);
                    if (response.payment_status == "Lunas") {
                        $("#sale_payment_action").html("");
                    }
                    var tr = "<tr id='tr_sale_payment_" + response.data.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + response.data.id +
                        "'>" + payment_date + "</td>" +
                        "<td>" + payment_amount + "</td>" +
                        "<td>" + sub_account_name + "</td>" +
                        "<td><div class='d-flex justify-content-center'>" +
                        // "<button type='button' class='btn btn-sm btn-warning mr-2' onclick='editSalePayment(" +
                        // response.data.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteConfirmationSalePayment(" +
                        response.data.id + ")'><i class='fas fa-trash-alt'></i></button></div>" +
                        "</td></tr>";

                    $('#payment-info tbody').append(tr);
                },
                error: function(xhr) {
                    if (xhr.status == 404) {
                        alert('Resource not found');
                    } else if (xhr.status == 500) {
                        alert('Internal Server Error');
                    } else {
                        alert('An error occurred: ' + xhr.statusText);
                    }
                }
            });
        }

        function deleteConfirmationSalePayment(id) {
            $.ajax({
                type: "GET",
                url: `/sale/sale-payment/delete-confirmation/${id}`,
                success: function(response) {
                    $("#modal-content").html(response.msg);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    if (xhr.status == 404) {
                        alert('Resource not found');
                    } else if (xhr.status == 500) {
                        alert('Internal Server Error');
                    } else {
                        alert('An error occurred: ' + xhr.statusText);
                    }
                }
            });
        }

        function deleteDataRemoveTR(id, route, tableName) {
            $.ajax({
                type: "DELETE",
                url: `${route}/${id}`,
                // url: `/sale/item-receive/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(data) {
                    if (data.status == "Success") {
                        $("#sale_payment_action").html("");

                        var sale_payment_button_element =
                            "<button type='button'style='width: fit-content;' class='btn btn-sm btn-success' onclick='createPayment({{ $sale_order->id }})'>Tambah Pembayaran Barang</button>"

                        $("#sale_payment_action").append(sale_payment_button_element);

                        $("#tr_" + tableName + "_" + id).remove();
                        toastr.success(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    if (xhr.status == 404) {
                        alert('Resource not found');
                    } else if (xhr.status == 500) {
                        alert('Internal Server Error');
                    } else {
                        alert('An error occurred: ' + xhr.statusText);
                    }
                }
            });
        }
        // End Payment

        function inputFormatRupiah(angka, prefix) {
            var number_string = angka.value.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            angka.value = prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endsection
