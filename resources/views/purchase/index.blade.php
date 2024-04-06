@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Pemesanan Pembelian</h1>
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

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data Pembelian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row justify-content-between">
                            <div class="col-md-6 mb-2 p-0">
                                <div class="input-group">
                                    <input type="search" class="typeahead form-control form-control-lg" id="item_search"
                                        placeholder="Cari Data Pembelian">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row justify-content-end">
                                    <label for="" class="col-sm-2 col-form-label">Status :</label>
                                    <div class="col-sm-2">
                                        <select class="custom-select" id="unit_id" name="unit_id">
                                            <option value="">All</option>
                                            <option value="">Belum Lunas</option>
                                            <option value="">Lunas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive p-0">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Total Biaya</th>
                                        <th>Pemasok</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_orders as $po)
                                        <tr id="tr_{{ $po->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_id_{{ $po->id }}">{{ $po->id }}</td>
                                            <td>
                                                {{ $po->date }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($po->total_price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $po->supplier->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('purchase.show', $po->id) }}"
                                                    class="btn btn-sm btn-info ml-0 mr-0" id="btnShow"
                                                    onclick="">Detil</button>
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

            </div>
        </section>
    </div>
@endsection
