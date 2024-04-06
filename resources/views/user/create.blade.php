@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Data User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Master User</li>
                            <li class="breadcrumb-item">Tambah Data User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="fullname"
                                 class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        placeholder="Nama Lengkap" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama Panggilan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama Panggilan" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="input-group date col-sm-10" id="dobDateHelper" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="dob"
                                        name="dob" data-target="#dobDateHelper" placeholder="YYYY/MM/dd" required/>
                                    <div class="input-group-append" data-target="#dobDateHelper"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Alamat" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-sm-2 col-form-label">Kelamin</label>
                                <div class="input-group col-sm-10">
                                    <div class="col-sm-2">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio1"
                                                name="gender" value="PRIA" checked>
                                            <label for="customRadio1" class="custom-control-label">Pria</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio2"
                                                name="gender" value="WANITA">
                                            <label for="customRadio2" class="custom-control-label">Wanita</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-2">
                                    <select class="custom-select" id="role_id" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal Bergabung</label>
                                <div class="input-group date col-sm-10" id="joinDateHelper" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="join_date"
                                        name="join_date" data-target="#joinDateHelper" placeholder="YYYY/MM/dd" required/>
                                    <div class="input-group-append" data-target="#joinDateHelper"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Simpan</button>
                            <a href="{{ url()->previous() }}" class="btn btn-default float-right"> Batal</a>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        //Date picker
        $('#dobDateHelper').datetimepicker({
            format: 'YYYY/MM/DD'
        });

        $('#joinDateHelper').datetimepicker({
            format: 'YYYY/MM/DD'
        });
    </script>
@endsection
