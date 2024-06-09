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
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullname" class="col-form-label">Nama Item</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Nama Item" value="{{ $item->name }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fullname" class="col-form-label">Harga Beli</label>
                                            <input type="number" class="form-control" id="buying_price" name="buying_price"
                                                placeholder="Harga" min="0" value="{{ $item->buying_price }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fullname" class="col-form-label">Harga Jual</label>
                                            <input type="number" class="form-control" id="selling_price"
                                                name="selling_price" placeholder="Harga" min="0"
                                                value="{{ $item->selling_price }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Satuan</label>
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
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="" class="col-form-label">Kategori Item</label>
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
