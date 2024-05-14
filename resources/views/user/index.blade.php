@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Master User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master User</li>
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
                        <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data User</h3>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('user.create') }}" style="width: fit-content"
                                    class="btn btn-sm btn-success ml-3">Tambah Pengguna</a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    @include('role/modal-create')
                    <!-- Modal End -->

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr id="tr_{{ $user->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_fullname_{{ $user->id }}">{{ $user->fullname }}</td>
                                        <td id="td_address_{{ $user->id }}">{{ $user->address }}</td>
                                        <td id="td_gender_{{ $user->id }}">{{ $user->gender }}</td>
                                        <td id="td_email_{{ $user->id }}">{{ $user->email }}</td>
                                        <td id="td_email_{{ $user->id }}">{{ $user->role->name }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                                                onclick="showUser({{ $user->id }})"><i class="fas fa-eye"></i></button>
                                            <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteConfirmation({{ $user->id }})"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $users->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        @if (Session::has('Success'))
            toastr.success("{{ session('Success') }}");
        @endif

        function deleteConfirmation(id) {
            $.ajax({
                type: "GET",
                url: `user/${id}/DeleteConfirmation`,
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

        function deleteRoleDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `user/${id}`,
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
