@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detil Data Pemesanan Pembelian</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Pembelian</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- form start -->
                <div class="form-group row mb-0">
                    <label for="supplier" class="col-sm-1 col-form-label">Pemasok</label>
                    <div class="col-sm-3">
                        <label class='form-control' @readonly(true)>
                            {{ $purchase_order->supplier->name }}
                        </label>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <label class="col-sm-1 col-form-label">Tanggal</label>
                    <div class="col-sm-2">
                        <label class='form-control' @readonly(true)>
                            {{ $purchase_order->date }}
                        </label>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="col-sm-1 col-form-label p-0">Total </label>
                    <label id="displayTotal" name="displayTotal" class="bold col-sm-3 m-0 p-0"
                        style="margin-left: 10px;font-size: large;">
                        @php
                            echo 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.');
                        @endphp
                    </label>
                </div>

                <!-- Detil Pemesanan Pembelian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pemesanan Pembelian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive p-0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Potongan</th>
                                        <th>Jumlah Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_order->purchase_details as $pd)
                                        <tr id="tr_{{ $pd->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $pd->qty }} {{ $pd->item->unit->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->discount, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->total_price, 0, ',', '.');
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->

                <div class="container-fluid m-0 w-100">
                    <div class="row w-100">
                        <!-- Detil Penerimaan Barang -->
                        <div class="col-sm-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Data Penerimaan Barang</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <a href="{{ route('purchase.createItemReceive', $purchase_order->id) }}" style="width: fit-content"
                                            class="btn btn-sm btn-success">Tambah Data Penerimaan Barang</a>
                                    </div><br>
                                    <div class="row table-responsive p-0">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Tanggal</th>
                                                    <th>Kode Penerimaan Barang</th>
                                                    <th>Detail Item</th>
                                                    <th>Gudang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase_order->purchase_details as $pd)
                                                    <tr id="tr_{{ $pd->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                                        <td>
                                                            @php
                                                                echo 'Rp ' . number_format($pd->price, 0, ',', '.');
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            {{ $pd->qty }} {{ $pd->item->unit->name }}
                                                        </td>
                                                        <td>
                                                            {{ $pd->qty }} {{ $pd->item->unit->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>

                        <!-- Pembayaran Pemesanan Pembelian Barang -->
                        <div class="col-sm-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pembayaran</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <a href="{{ route('purchase.create') }}" style="width: fit-content"
                                            class="btn btn-sm btn-success">Tambah Data Pembayaran Barang</a>
                                        {{-- <a href="{{ route('purchase.itemReceive') }}" style="width: fit-content"
                                                class="btn btn-sm btn-success">Tambah Data Penerimaan Barang</a> --}}
                                    </div><br>
                                    <div class="row table-responsive p-0">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                    <th>Akun</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase_order->purchase_details as $pd)
                                                    <tr id="tr_{{ $pd->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                                        <td>
                                                            {{ $pd->price }}
                                                        </td>
                                                        <td>
                                                            {{ $pd->qty }} {{ $pd->item->unit->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
