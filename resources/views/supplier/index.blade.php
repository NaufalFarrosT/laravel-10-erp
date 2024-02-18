@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Master Pemasok</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Pemasok</li>
                        </ol>
                    </div>
                </div>
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
                        <h3 class="card-title">Data Pemasok</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    @include('supplier/modal-create')
                    <!-- Modal End -->

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <button type="button" style="width: fit-content" class="btn btn-sm btn-success"
                                    data-toggle="modal" data-target="#modal-create">Tambah
                                    Data Pemasok</button>
                            </div>
                        </div><br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Pemasok</th>
                                    <th>Alamat</th>
                                    <th style="width: 18%">Aksi</th>
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
                                            <button type="button" style="width: 60px" class="btn btn-sm btn-primary"
                                                id="btnShow"
                                                onclick="showAllUserBasedOnSupplier({{ $supplier->id }})">Detil</button>
                                            <button type="button" style="width: 60px" class="btn btn-sm btn-warning"
                                                onclick="editSupplierData({{ $supplier->id }})">Ubah</button>
                                            <button type="button" style="width: 60px" class="btn btn-sm btn-danger"
                                                onclick="deleteConfirmation({{ $supplier->id }})">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
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
                        "<td><button type='button' style='width: 60px' class='btn btn-sm btn-primary' id='btnShow' onclick='showAllUserBasedOnSupplier(" +
                        data.data.id + ")'>Detil</button>" +
                        "<button type='button' style='width: 60px' class='btn btn-sm btn-warning' onclick='editSupplierData(" +
                        data.data.id + ")'>Ubah</button>" +
                        "<button type='button' style='width: 60px' class='btn btn-sm btn-danger' onclick='deleteConfirmation(" +
                        data.data.id + ")'>Hapus</button>" +
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
