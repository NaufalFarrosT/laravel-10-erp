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
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-content">

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Pemasok</h3>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="card-tools mr-2">
                                    <form id="filterForm" class="flex-fill" method="GET"
                                        action="{{ route('supplier.index') }}">
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
                                    Pemasok</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    @include('supplier/modal-create')
                    <!-- Modal End -->

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Pemasok</th>
                                    <th>Alamat</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr id="tr_{{ $supplier->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $supplier->id }}">{{ $supplier->name }}</td>
                                        <td id="td_address_{{ $supplier->id }}">
                                            {{ $supplier->address }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                                                onclick="showAllUserBasedOnSupplier({{ $supplier->id }})"><i
                                                    class="fas fa-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editSupplierData({{ $supplier->id }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteConfirmation({{ $supplier->id }})"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $suppliers->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        function storeSupplierData() {
            var name = $("#name").val();
            var address = $("#address").val();
            var numberOfRow = $(".table-bordered tr").length - 0;

            $.ajax({
                type: "POST",
                url: `supplier`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: name,
                    address: address
                },
                success: function(data) {
                    toastr.success(data.msg);
                    var tr = "<tr id='tr_" + data.data.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + data.data.id +
                        "'>" + name + "</td>" +
                        "<td>" + address + "</td>" +
                        "<td><button type='button' class='btn btn-sm btn-primary' id='btnShow' onclick='showAllUserBasedOnSupplier(" +
                        data.data.id + ")'><i class="
                    fas fa - eye "></i></button>" +
                        "<button type='button' class='btn btn-sm btn-warning' onclick='editSupplierData(" +
                        data.data.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteConfirmation(" +
                        data.data.id + ")'><i class='fas fa-trash-alt '></i></button>" +
                        "</td></tr>";

                    $('.table-bordered tbody').append(tr);
                    $('#name').val("");
                    $('#address').val("");
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editSupplierData(id) {
            $.ajax({
                type: "GET",
                url: `supplier/${id}/edit`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveSupplierDataUpdateTD(id) {
            var eName = $("#eName").val();
            var eAddress = $("#eAddress").val();

            $.ajax({
                type: "PUT",
                url: `supplier/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: eName,
                    address: eAddress
                },
                success: function(data) {
                    $("#td_name_" + id).html(eName);
                    $("#td_address_" + id).html(eAddress);
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
                url: `supplier/${id}/DeleteConfirmation`,
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

        function deleteSupplierDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `supplier/${id}`,
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

        function showAllItemBasedOnSupplier(id) {
            $.ajax({
                type: "GET",
                url: `supplier/${id}`,
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
