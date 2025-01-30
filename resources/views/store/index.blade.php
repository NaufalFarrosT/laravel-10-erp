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

                <!-- Modal Start -->
                @include('store/modal-create')
                <!-- Modal End -->

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
                        <h3 class="mb-0">Data Toko</h3>

                        {{-- <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Toko</h3>

                            <div class="d-flex flex-wrap justify-content-between">

                                <div class="card-tools mr-2">
                                    <form id="filterForm" class="flex-fill" method="GET"
                                        action="{{ route('store.index') }}">
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
                                    Toko</button>
                            </div>
                        </div> --}}
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="container ml-0 mb-2 pl-0">
                            <button type="button" style="" class="btn btn-m btn-success" data-toggle="modal"
                                data-target="#modal-create">Tambah Toko</button>
                        </div>
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Toko</th>
                                    <th>Alamat</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                    <tr id="tr_{{ $store->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $store->id }}">{{ $store->name }}</td>
                                        <td id="td_address_{{ $store->id }}">{{ $store->address }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                                                onclick="show({{ $store->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editWarehouseData({{ $store->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleleConfirmationWarehouseData({{ $store->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $stores->links() }}
                        </ul>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        function storeWarehouseData() {
            var input_store_name = $("#storeName").val();
            var input_store_address = $("#storeAddress").val();

            var number_of_row = $(".table-bordered tr").length - 0;

            $.ajax({
                type: "POST",
                url: `store`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    store_name: input_store_name,
                    store_address: input_store_address,
                },
                success: function(response) {
                    toastr.success(response.msg);
                    var tr = "<tr id='tr_" + response.new_store.id + "'>" +
                        "<td>" + number_of_row + "</td>" +
                        "<td id='td_name_" + response.new_store.id +
                        "'>" + input_store_name + "</td>" +
                        "<td id='td_address_" + response.new_store.id +
                        "'>" + input_store_address + "</td>" +
                        "<td><button type='button' class='btn btn-sm btn-primary' id='btnShow' onclick='show(" +
                        response.new_store.id +
                        ")'><i class='fas fa-eye'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-warning' onclick='editWarehouseData(" +
                        response.new_store.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleleConfirmationWarehouseData(" +
                        response.new_store.id + ")'><i class='fas fa-trash-alt'></i></button>" +
                        "</td></tr>";

                    $('.table-bordered tbody').append(tr);
                    $('#inputName').val("");
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editWarehouseData(id) {
            $.ajax({
                type: "GET",
                url: `store/${id}/edit`,
                success: function(response) {
                    $("#modal-content").html(response.modal);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveDataUpdateTD(id) {
            var eWarehouseName = $("#eWarehouseName").val();
            var eWarehouseAddress = $("#eWarehouseAddress").val();

            $.ajax({
                type: "PUT",
                url: `store/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    store_name: eWarehouseName,
                    store_address: eWarehouseAddress,
                },
                success: function(data) {
                    $("#td_name_" + id).html(eWarehouseName);
                    $("#td_address_" + id).html(eWarehouseAddress);
                    toastr.success(data.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleleConfirmationWarehouseData(id) {
            $.ajax({
                type: "GET",
                url: `store/${id}/DeleteConfirmation`,
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

        function deleteWarehouseDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `store/${id}`,
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
