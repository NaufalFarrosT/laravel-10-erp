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
                <div class="p-1">
                    <div class="form-group row">
                        <label for="supplier" class="col-sm-1 col-form-label">Pemasok</label>
                        <div class="col-sm-3">
                            <label class='form-control' @readonly(true)>
                                {{ $purchase_order->supplier->name }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">Tanggal</label>
                        <div class="col-sm-2">
                            <label class='form-control' @readonly(true)>
                                {{ $purchase_order->date }}
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="col-sm-1 col-form-label">Total </label>
                    <label id="displayTotal" name="displayTotal" class="bold col-sm-3"
                        style="margin-left: 10px;font-size: large;">{{ $purchase_order->total_price }}</label>
                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detil Pemesanan Pembelian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Item</th>
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
                                            {{ $pd->price }}
                                        </td>
                                        <td>
                                            {{ $pd->qty }} {{ $pd->item->unit->name }}
                                        </td>
                                        <td>
                                            {{ $pd->discount }}
                                        </td>
                                        <td>
                                            {{ $pd->total_price }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    </div>
                    <!-- /.card-footer -->

                </div>
                <!-- /.card -->

            </div>
        </section>
    </div>
@endsection
