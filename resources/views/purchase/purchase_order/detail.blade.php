@extends('layouts.adminlte')
@section('content-header')
    <li class="nav-item d-none d-sm-inline-block">
        <h3>Detil Pembelian</h3>
    </li>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <a href="{{ Route('purchase.index') }}" class="btn btn-lg btn-default ml-2"> Kembali</a>
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

                <input type="hidden" id="purchase_order_id" value={{ $purchase_order->id ?? 0 }}>

                <!-- form start -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-size: 24px;">Detail Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <label for="supplier" class="col-12 col-lg-1 col-form-label">Pemasok</label>
                            <div class="col-sm-3">
                                <label class='form-control' @readonly(true)>
                                    {{ $purchase_order->supplier->name }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-12 col-lg-1 col-form-label">Tanggal</label>
                            <div class="col-sm-2">
                                <input type='text' class='form-control'
                                    value='{{ \Carbon\Carbon::parse($purchase_order->date)->format('d-m-Y') }}' readonly>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="col-sm-1 col-form-label p-0">Total </label>
                            <label id="displayTotal" name="displayTotal" class="bold col-sm-3 m-0 p-0"
                                style="margin-left: 10px;font-size: large;">
                                @php
                                    echo 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.');
                                @endphp
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card Penerimaan Barang & Pembayaran -->
                <div class="container-fluid m-0 w-100 p-0">
                    <div class="row">
                        <!-- Penerimaan Barang -->
                        <div class="col-sm-6">
                            @include('purchase.item_receive.table')
                        </div>

                        <!-- Pembayaran Barang -->
                        <div class="col-sm-6">
                            @include('purchase.payment.table')
                        </div>
                    </div>
                </div>
                <!-- End Card Penerimaan Barang & Pembayaran -->


                <!-- Card <i class="fas fa-eye"></i> Pembelian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pembelian Barang</h3>
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
                                    @foreach ($purchase_order->purchase_details as $pd)
                                        <tr id="tr_{{ $pd->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $pd->qty }} {{ $pd->item->unit->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->discount, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->total_price, 0, ',', '.');
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
                <!-- End Card <i class="fas fa-eye"></i> Pembelian -->
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        // Item Receive
        function deleteConfirmationItemReceive(id) {
            console.log(id)
            $.ajax({
                type: "GET",
                url: `/purchase/item-receive/delete-confirmation/${id}`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
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
                // url: `/purchase/item-receive/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(data) {
                    if (data.status == "Success") {
                        console.log(data)
                        if (tableName == "item_receive") {
                            $("#item_receive_action").html("");
                            var purchase_order_id = $("#purchase_order_id").val();

                            var route =
                                "{{ route('item-receive.createWithID', ':purchase_order_id') }}"
                            route = route.replace(':purchase_order_id', purchase_order_id);
                            var item_receive_button_element = "<a href='" + route +
                                "' style='width: fit-content' class='btn btn-sm btn-success'>" +
                                "Tambah Penerimaan Barang</a>"

                            $("#item_receive_action").append(item_receive_button_element);
                        } else if (tableName == "purchase_payment") {
                            $("#purchase_payment_action").html("");

                            var purchase_payment_button_element =
                                "<button id='btn_add_purchase_payment' type='button'style='width: fit-content;' class='btn btn-sm btn-success' onclick='createPayment({{ $purchase_order->id }})'>Tambah Pembayaran Barang</button>"

                            $("#purchase_payment_action").append(purchase_payment_button_element);
                        }

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
        // End Item Receive

        // Payment
        // Trigger modal create payment after click payment
        function createPayment(purchase_order_id) {
            console.log(purchase_order_id)
            $.ajax({
                type: "GET",
                url: "{{ route('purchase-payment.create') }}",
                data: {
                    purchase_order_id: purchase_order_id,
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
            var account_id = $("#account_id").val();
            var sub_account_name = $("#account_id option:selected").text();
            var purchase_order_id = $('#purchase_order_id').val();

            var payment_amount_integer_format = payment_amount.replace(/Rp\.|\./g, '').trim();
            var numberOfRow = $("#payment-info tr").length - 0;

            $.ajax({
                type: "POST",
                url: `{{ route('purchase-payment.store') }}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    date: payment_date,
                    amount: payment_amount_integer_format,
                    account: account_id,
                    po_id: purchase_order_id,
                },
                success: function(response) {
                    toastr.success(response.msg);
                    if (response.payment_status == "Lunas") {
                        $("#purchase_payment_action").html("");
                    }

                    var tr = "<tr id='tr_purchase_payment_" + response.data.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_purchase_payment_date_" + response.data.id + "'>" +
                        payment_date + "</td>" +
                        "'<td id='td_purchase_payment_date_" + response.data.id + "'>" +
                        response.data.code + "</td>" +
                        "<td id='td_purchase_payment_amount_" + response.data.id + "'>" +
                        payment_amount + "</td>" +
                        "<td id='td_purchase_payment_sub_account_" + response.data.id + "'>" +
                        sub_account_name + "</td>" +
                        "<td><div class='d-flex justify-content-center'><button type='button' class='btn btn-sm btn-warning mr-2' onclick='editPaymentData(" +
                        response.data.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteConfirmationPurchasePayment(" +
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

        function editPaymentData(id) {
            $.ajax({
                type: "GET",
                url: `purchase-payment/${id}/edit`,
                success: function(response) {
                    $("#modal-content").html(response.data);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function updatePaymentData(id) {
            var input_date = $("#eDatePicker").val();
            var input_sub_account = $("#eAccount_id").val();
            var sub_account_text = $("#eAccount_id option:selected").text();
            var input_amount = $("#ePayment_amount").val();
            var input_amount_integer_format = input_amount.replace(/Rp\.|\./g, '').trim();

            $.ajax({
                type: "PUT",
                url: `purchase-payment/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    date: input_date,
                    amount: input_amount_integer_format,
                    sub_account_id: input_sub_account,
                },
                success: function(response) {
                    if (response.payment_status == "Lunas") {
                        $("#purchase_payment_action").html("");
                    } else if ($('#purchase_payment_action').find('#btn_add_purchase_payment').length == 0) {
                        var purchase_payment_button_element =
                            "<button id='btn_add_purchase_payment' type='button'style='width: fit-content;' class='btn btn-sm btn-success' onclick='createPayment({{ $purchase_order->id }})'>Tambah Pembayaran Barang</button>"

                        $("#purchase_payment_action").append(purchase_payment_button_element);
                    }

                    $("#td_purchase_payment_date_" + id).html(input_date);
                    $("#td_purchase_payment_amount_" + id).html(input_amount);
                    $("#td_purchase_payment_sub_account_" + id).html(sub_account_text);
                    toastr.success(response.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleteConfirmationPurchasePayment(id) {
            $.ajax({
                type: "GET",
                url: `/purchase/purchase-payment/delete-confirmation/${id}`,
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
