@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Jabatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Jabatan</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Jabatan</h3>

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

                    @include('role/modal-add')

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <button type="button" style="width: fit-content" data-toggle="modal"
                                    data-target="#modal-create" class="btn btn-sm btn-success">Tambah
                                    Data Jabatan</button>
                            </div>
                        </div><br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Role</th>
                                    <th>Jumlah</th>
                                    <th style="width: 18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr id="tr_{{ $role->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $role->id }}">{{ $role->name }}</td>
                                        <td>
                                            {{ $role->total }}
                                        </td>
                                        <td>
                                            <button type="button" style="width: 60px"
                                                class="btn btn-sm btn-primary">Detil</button>
                                            <button type="button" style="width: 60px"
                                                class="btn btn-sm btn-warning">Ubah</button>
                                            <button type="button" style="width: 60px" class="btn btn-sm btn-danger"
                                                onclick="if(confirm('Anda yakin?')) deleteDataRoleRemoveTR({{ $role->id }})">Hapus</button>
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
        function storeRoleData() {
            var name = $("#inputName").val();

            $.ajax({
                type: "POST",
                url: `role`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: name
                },
                success: function(data) {
                    alert("sukses");
                    console.log(data);
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editForm(id) {
            $.ajax({
                type: "GET",
                url: `role/${id}/edit`,
                success: function(data) {
                    $("#modalContent").html(data.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveDataRoleUpdateTD(id) {
            var eName = $("#eName").val();
            $.ajax({
                type: "PUT",
                url: `role/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: eName
                },
                success: function(data) {
                    if (data.status == "Success") {
                        $("#td_name_" + id).html(eName);
                        toastr.success(data.msg);
                    }
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleteDataRoleRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `role/${id}`,
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
    </script>
@endsection
