@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Modal -->
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-content">

                        </div>
                    </div>
                </div>
                <!-- Modal End -->

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap">
                            <form id="filterForm" class="flex-fill" method="GET"
                                action="{{ route('transaction.index') }}">
                                <div class="row">
                                    <div class="col-sm-3 mb-2">
                                        <h3 class="mb-0">Data Pendapatan / Pengeluaran</h3>
                                    </div>
                                    <div class="col-sm-2 mb-2">
                                        <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                            style="height: 31px; width: fit-content;">
                                            <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mt-2" id="dateRange"
                                                    name="dateRange" value="{{ $date_range != null ? $date_range : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-2">
                                        <button type="submit" class="btn btn-m btn-primary">Filter</button>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <div class="input-group input-group-m mb-0 mr-3 p-0">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search"
                                                value="{{ $table_search != null ? $table_search : '' }}">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <button type="button" style="" class="btn btn-m btn-success"
                                            onclick="createData(1)">Tambah
                                            Pendapatan</button>
                                        <button type="button" style="" class="btn btn-m btn-danger"
                                            onclick="createData(2)">Tambah
                                            Pengeluaran</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Detil</th>
                                        <th>Total Biaya</th>
                                        <th>Metode Pembayaran</th>
                                        <th style="width: 130px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr id="tr_{{ $transaction->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_code_{{ $transaction->id }}">{{ $transaction->code }}</td>
                                            <td id="td_date_{{ $transaction->id }}">
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d-M-Y') }}
                                            </td>
                                            <td id="td_information_{{ $transaction->id }}">
                                                {{ $transaction->information }}
                                            </td>
                                            <td id="td_amount_{{ $transaction->id }}">
                                                @php
                                                    echo 'Rp. ' . number_format($transaction->amount, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td id="td_sub_account_{{ $transaction->id }}">
                                                {{ $transaction->sub_account->name }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                                                    onclick="show({{ $transaction->id }})"><i
                                                        class="fas fa-eye"></i></button>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="editData({{ $transaction->id }})"><i
                                                        class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="deleteConfirmation({{ $transaction->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
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
                <!-- /.card -->

            </div>
        </section>
    </div>
@endsection
@section('javascript-function')
    <script type="text/javascript">
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

        $(function() {
            $('#dateRange').daterangepicker({
                locale: {
                    format: 'DD-MMM-YYYY'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'All Time': [moment('2020-01-01'), moment()],
                }
            });
        });

        function createData(input_transaction_type) {
            $.ajax({
                type: "GET",
                url: `/transaction/create`,
                data: {
                    transaction_type: input_transaction_type
                },
                success: function(response) {
                    $("#modal-content").html(response.data);
                    $("#modal-default").modal('show');
                },
            })
        }

        function storeData(input_transaction_type_id) {
            var input_date = $("#datePicker").val();
            var input_amount = $("#amount").val();
            var input_amount_integer_format = input_amount.replace(/Rp\.|\./g, '').trim();

            var input_information = $("#information").val();
            var input_sub_account = $("#account_id").val();
            var sub_account_text = $("#account_id option:selected").text();
            var numberOfRow = $(".table-bordered tr").length - 0;

            $.ajax({
                type: "POST",
                url: `{{ route('transaction.store') }}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    date: input_date,
                    amount: input_amount_integer_format,
                    information: input_information,
                    transaction_type_id: input_transaction_type_id,
                    sub_account_id: input_sub_account
                },
                success: function(response) {
                    console.log(response.request);
                    toastr.success(response.msg);
                    var tr = "<tr id='tr_" + response.data.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_code_" + response.data.id +
                        "'>" + response.data.code + "</td>" +
                        "<td id='td_date_" + response.data.id +
                        "'>" + response.data.date + "</td>" +
                        "<td id='td_information_" + response.data.id +
                        "'>" + response.data.information + "</td>" +
                        "<td id='td_amount_" + response.data.id +
                        "'>" + input_amount + "</td>" +
                        "<td id='td_sub_account_" + response.data.id +
                        "'>" + sub_account_text + "</td>" +
                        "<td><button type='button' class='btn btn-sm btn-primary' id='btnShow' onclick='show(" +
                        response.data.id +
                        ")'><i class='fas fa-eye '></i></button>" +
                        "<button type='button' class='btn btn-sm btn-warning' onclick='editData(" +
                        response.data.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteConfirmation(" +
                        response.data.id + ")'><i class='fas fa-trash-alt '></i></button>" +
                        "</td></tr>";

                    $('.table-bordered tbody').append(tr);
                    $('#inputName').val("");
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editData(id) {
            $.ajax({
                type: "GET",
                url: `transaction/${id}/edit`,
                success: funct ion(response) {
                    $("#modal-content").html(response.data);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveDataUpdateTD(id) {
            var input_date = $("#eDatePicker").val();
            var input_sub_account = $("#eAccount_id").val();
            var sub_account_text = $("#eAccount_id option:selected").text();
            var input_amount = $("#eAmount").val();
            var input_amount_integer_format = input_amount.replace(/Rp\.|\./g, '').trim();
            var input_information = $("#eInformation").val();

            $.ajax({
                type: "PUT",
                url: `transaction/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    date: input_date,
                    amount: input_amount_integer_format,
                    information: input_information,
                    sub_account_id: input_sub_account
                },
                success: function(response) {
                    $("#td_date_" + id).html(input_date);
                    $("#td_information_" + id).html(input_information);
                    $("#td_amount_" + id).html(input_amount);
                    $("#td_sub_account_" + id).html(sub_account_text);
                    toastr.success(response.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleteConfirmation(id) {
            $.ajax({
                type: "GET",
                url: `transaction/${id}/DeleteConfirmation`,
                success: function(response) {
                    $("#modal-content").html(response.data);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                    alert('Error');
                }
            });
        }

        function deleteDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `transaction/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(response) {
                    if (response.status == "Success") {
                        $("#tr_" + id).remove();
                        toastr.success(response.msg);
                    } else {
                        alert(response.msg);
                    }
                },
            });
        }
    </script>
@endsection
