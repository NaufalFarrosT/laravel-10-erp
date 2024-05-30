@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
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
                        <h3 class="mb-0">Data Akun</h3>

                        {{-- <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Akun</h3>

                            <div class="d-flex flex-wrap justify-content-between">

                                <div class="card-tools mr-2">
                                    <form id="filterForm" class="flex-fill" method="GET"
                                        action="{{ route('account.index') }}">
                                        <div class="input-group input-group-m" style="width: 300px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search"
                                                value="{{ $table_search != null ? $table_search : '' }}">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <button type="button" style="" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-create">Tambah
                                    Akun</button>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Modal Start -->
                    @include('account/modal-create')
                    <!-- Modal End -->

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="container ml-0 mb-2 pl-0">
                            <button type="button" style="" class="btn btn-m btn-success" data-toggle="modal"
                                data-target="#modal-create">Tambah Akun</button>
                        </div>
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Akun</th>
                                    <th>Saldo</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_accounts as $account)
                                    <tr id="tr_{{ $account->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $account->id }}">{{ $account->name }}</td>
                                        <td id="td_balance_{{ $account->id }}">
                                            @php
                                                echo 'Rp ' . number_format($account->balance, 0, ',', '.');
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-sm btn-warning mr-2"
                                                    onclick="editData({{ $account->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteConfirmation({{ $account->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $sub_accounts->links() }}
                        </ul>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        function storeData() {
            var account_name = $("#account_name").val();
            var balance = $("#balance").val();
            var numberOfRow = $(".table-bordered tr").length - 0;

            console.log(account_name)
            console.log(balance)

            $.ajax({
                type: "POST",
                url: `/account`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    account_name: account_name,
                    balance: balance
                },
                success: function(data) {
                    var tr = "<tr id='tr_" + data.account.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + data.account.id +
                        "'>" + account_name + "</td>" +
                        "<td id='td_balance_" + data.account.id + "'>Rp " + data.account.balance + "</td>" +
                        "<td><div class='d-flex justify-content-center'>" +
                        "<button class='btn btn-sm btn-warning mr-2'" +
                        "onclick='editData(" + data.account.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button class='btn btn-sm btn-danger'" +
                        "onclick='deleteConfirmation(" + data.account.id +
                        ")'><i class='fas fa-trash-alt'></i></button></div></td></tr>";

                    $('.table-bordered tbody').append(tr);
                    $('#account_name').val("");
                    $('#balance').val("");
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editData(id) {
            $.ajax({
                type: "GET",
                url: `account/${id}/edit`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveDataUpdateTD(id) {
            var eName = $("#eName").val();
            var eBalance = $("#eBalance").val();
            $.ajax({
                type: "PUT",
                url: `account/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: eName,
                    balance: eBalance,
                },
                success: function(data) {
                    $("#td_name_" + id).html(eName);
                    $("#td_balance_" + id).html("Rp " + eBalance);
                    toastr.success(data.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleteConfirmation(id) {
            $.ajax({
                type: "GET",
                url: `account/${id}/DeleteConfirmation`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
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
                url: `account/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(data) {
                    if (data.status == "Success") {
                        $("#tr_" + id).remove();
                        toastr.success(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },
            });
        }

        function show(id) {
            $.ajax({
                type: "GET",
                url: `role/${id}`,
                success: function(data) {
                    //console.log(data.users);
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert("Error");
                },
            });
        }
    </script>
@endsection
