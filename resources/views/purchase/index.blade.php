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
                        <h3 class="">Data Pembelian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between mb-2">
                            <div>
                                <a href="{{ route('purchase.create') }}" class="btn btn-m btn-success">Tambah
                                    Pembelian</a>
                            </div>
                            <form id="filterForm" method="GET" action="{{ route('purchase.index') }}">
                                <div class="d-flex flex-wrap">
                                    <div class="form-group d-flex align-items-center mr-3 m-0 p-0">
                                        <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="dateRange" name="dateRange"
                                                value="{{ $date_range != null ? $date_range : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group d-flex align-items-center m-0 p-0" style="height: 31px; ">
                                        <label for="statusSelect" class="mb-0 mr-2">Status:</label>
                                        <div class="input-group">
                                            <select class="custom-select mt-2" id="po_status" name="po_status">
                                                <option value="All" {{ $po_status == 'All' ? 'selected' : '' }}>
                                                    All
                                                </option>
                                                <option value="Proses" {{ $po_status == 'Proses' ? 'selected' : '' }}>
                                                    Proses</option>
                                                <option value="Selesai" {{ $po_status == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-m btn-primary mt-2 ml-2 btn-no-margin-right">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="dataTable" class="table table-bordered table-responsive-xl">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Total Biaya</th>
                                    <th>Pemasok</th>
                                    <th>Status</th>
                                    <th>Status Barang</th>
                                    <th>Status Pembayaran</th>
                                    <th style="width: 50px"></th>
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
                        {{-- <div class="row table-responsive">
                            <table id="dataTable" class="table table-bordered">
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
                        </div> --}}
                    </div>
                    <!-- /.card-body -->

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
