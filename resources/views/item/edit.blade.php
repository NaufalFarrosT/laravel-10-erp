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
                <div class="col align-self-center">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="mb-0">Ubah Data Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ route('item.update', $item->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Nama Item</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control col-sm-6" id="name" name="name"
                                            placeholder="Nama Item" value="{{ $item->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Stok</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control col-sm-2" id="stock" name="stock"
                                            placeholder="Jumlah Stok" min="0" value="{{ $item->stock }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fullname" class="col-sm-2 col-form-label">Harga</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control col-sm-2" id="price" name="price"
                                            placeholder="Harga" min="0" value="{{ $item->price }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Satuan</label>
                                    <div class="col-sm-2">
                                        <select class="custom-select" id="unit_id" name="unit_id">
                                            @foreach ($units as $unit)
                                                @if ($item->unit_id == $unit->id)
                                                    <option value="{{ $unit->id }}" selected>{{ $unit->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Kategori Item</label>
                                    <div class="col-sm-3">
                                        <select class="custom-select" id="category_id" name="category_id">
                                            @foreach ($categories as $category)
                                                @if ($item->category_id == $category->id)
                                                    <option value="{{ $category->id }}" selected>{{ $category->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
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
