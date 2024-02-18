@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Data Item</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/item">Master Item</a></li>
                            <li class="breadcrumb-item">Tambah Data Item</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col align-self-center">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ route('item.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Nama Item</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control col-sm-6" id="name" name="name"
                                            placeholder="Nama Item" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Stok</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control col-sm-2" id="stock" name="stock"
                                            placeholder="Jumlah Stok" min="0" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Harga</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control col-sm-2" id="price" name="price"
                                            placeholder="Harga" min="0" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Satuan</label>
                                    <div class="col-sm-2">
                                        <select class="custom-select" id="unit_id" name="unit_id">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Pemasok</label>
                                    <div class="col-sm-2">
                                        <select class="custom-select" id="supplier_id" name="supplier_id">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Kategori Item</label>
                                    <div class="col-sm-2">
                                        <select class="custom-select" id="category_id" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
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
            </div>
        </section>
    </div>
@endsection
