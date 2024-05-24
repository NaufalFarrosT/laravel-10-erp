@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap">
                            <form id="filterForm" class="flex-fill" method="GET" action="{{ route('purchase.index') }}">
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-2 mb-2 mb-0">
                                        <h3 class="">Data Pembelian</h3>
                                    </div>
                                    <div class="col-12 col-lg-2 mb-2">
                                        <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                            style="height: 31px; width: fit-content;">
                                            <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mt-2" id="dateRange"
                                                    name="dateRange" value="{{ $date_range != null ? $date_range : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-lg-3">
                                        <div class="d-flex justify-content-start justify-content-md-end">
                                            <div class="form-group d-flex">
                                                <label for="statusSelect">Status:</label>
                                                <div class="input-group">
                                                    <select class="custom-select mt-2" id="po_status" name="po_status">
                                                        <option value="All" {{ $po_status == 'All' ? 'selected' : '' }}>
                                                            All
                                                        </option>
                                                        <option value="Proses"
                                                            {{ $po_status == 'Proses' ? 'selected' : '' }}>
                                                            Proses</option>
                                                        <option value="Selesai"
                                                            {{ $po_status == 'Selesai' ? 'selected' : '' }}>
                                                            Selesai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-m btn-primary mt-2">Filter</button>

                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-lg-3 mb-2">
                                        <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                            style="height: 31px; width: fit-content;">
                                            <label for="statusSelect" class="mb-0 mr-2">Status:</label>
                                            <div class="input-group">
                                                <select class="custom-select mt-2" id="po_status" name="po_status">
                                                    <option value="All" {{ $po_status == 'All' ? 'selected' : '' }}>All
                                                    </option>
                                                    <option value="Proses" {{ $po_status == 'Proses' ? 'selected' : '' }}>
                                                        Proses</option>
                                                    <option value="Selesai" {{ $po_status == 'Selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-m btn-primary mt-2">Filter</button>

                                        </div>
                                    </div>

                                    <div class="col-sm-3 mb-2">
                                        <div class="input-group input-group-m mb-0 p-0">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search"
                                                value="{{ $table_search != null ? $table_search : '' }}">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-2 mb-2">
                                        <div class="p-0 d-flex justify-content-start justify-content-md-end">
                                            <a href="{{ route('purchase.create') }}" style="width: fit-content"
                                                class="btn btn-m btn-success">Tambah Pembelian</a>
                                        </div>
                                    </div>
                                    {{-- <div class="col-8">
                                        <div class="row">
                                            <div class="col-sm-auto mb-2">
                                                <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                                    style="height: 31px; width: fit-content;">
                                                    <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control mt-2" id="dateRange"
                                                            name="dateRange" value="{{ $date_range != null ? $date_range : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                                    style="height: 31px; width: fit-content;">
                                                    <label for="statusSelect" class="mb-0 mr-2">Status:</label>
                                                    <div class="input-group">
                                                        <select class="custom-select mt-2" id="po_status" name="po_status">
                                                            <option value="All" {{ $po_status == 'All' ? 'selected' : '' }}>All
                                                            </option>
                                                            <option value="Proses" {{ $po_status == 'Proses' ? 'selected' : '' }}>
                                                                Proses</option>
                                                            <option value="Selesai" {{ $po_status == 'Selesai' ? 'selected' : '' }}>
                                                                Selesai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <button type="submit" class="btn btn-m btn-primary">Filter</button>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <div class="input-group input-group-m mb-0 mr-3 p-0">
                                                    <input type="text" name="table_search" class="form-control float-right"
                                                        placeholder="Search"
                                                        value="{{ $table_search != null ? $table_search : '' }}">
        
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-default">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 mb-2">
                                                <a href="{{ route('purchase.create') }}" style="width: fit-content"
                                                class="btn btn-m btn-success">Tambah Pembelian</a>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                                {{-- <div class="d-flex flex-wrap justify-content-between">
                                    <h3 class="mb-0">Data Pembelian</h3>

                                    <div class="d-flex flex-wrap">
                                        <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                            style="height: 31px; width: fit-content;">
                                            <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mt-2" id="dateRange"
                                                    name="dateRange" value="{{ $date_range != null ? $date_range : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                            style="height: 31px; width: fit-content;">
                                            <label for="statusSelect" class="mb-0 mr-2">Status:</label>
                                            <div class="input-group">
                                                <select class="custom-select mt-2" id="po_status" name="po_status">
                                                    <option value="All" {{ $po_status == 'All' ? 'selected' : '' }}>All
                                                    </option>
                                                    <option value="Proses" {{ $po_status == 'Proses' ? 'selected' : '' }}>
                                                        Proses</option>
                                                    <option value="Selesai" {{ $po_status == 'Selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-m btn-primary">Filter</button>
                                    </div>

                                    <div class="input-group input-group-m mb-0 mr-3 p-0">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search" value="{{ $table_search != null ? $table_search : '' }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                            </form>
                            {{-- <a href="{{ route('purchase.create') }}" style="width: fit-content"
                                class="btn btn-m btn-success">Tambah Pembelian</a> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Total Biaya</th>
                                        <th>Pemasok</th>
                                        <th>Status</th>
                                        <th>Status Barang</th>
                                        <th>Status Pembayaran</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_orders as $po)
                                        <tr id="tr_{{ $po->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_code_{{ $po->id }}">{{ $po->code }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($po->date)->format('d-M-Y') }}
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
                                                @if ($po->status == 'Selesai')
                                                    <label class="badge bg-success">{{ $po->status }}</label>
                                                @else
                                                    <label class="badge bg-warning">{{ $po->status }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($po->item_receive_status == 'Diterima')
                                                    <label class="badge bg-success">{{ $po->item_receive_status }}</label>
                                                @else
                                                    <label class="badge bg-warning">{{ $po->item_receive_status }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($po->payment_status == 'Lunas')
                                                    <label class="badge bg-success">{{ $po->payment_status }}</label>
                                                @else
                                                    <label class="badge bg-warning">{{ $po->payment_status }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('purchase.show', $po->id) }}"
                                                    class="btn btn-sm btn-info ml-0 mr-0" id="btnShow">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
@section('javascript-function')
    <script type="text/javascript">
        $('#purchaseDate').datepicker({
            format: 'dd-M-yyyy', // Display format where 'M' is the short month name
            autoclose: true
        });

        $(function() {
            $('#dateRange').daterangepicker({
                locale: {
                    format: 'DD-MMM-YYYY'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'All Time': [moment('2020-01-01'), moment()],
                }
            });
        });
    </script>
@endsection
