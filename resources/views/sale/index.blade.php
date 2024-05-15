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
                            <form id="filterForm" class="flex-fill" method="GET" action="{{ route('sale.index') }}">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <h3 class="mb-0">Data Penjualan</h3>

                                    <div class="d-flex">
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
                                                <select class="custom-select mt-2" id="so_status" name="so_status">
                                                    <option value="All" {{ $so_status == 'All' ? 'selected' : '' }}>All
                                                    </option>
                                                    <option value="Proses" {{ $so_status == 'Proses' ? 'selected' : '' }}>
                                                        Proses</option>
                                                    <option value="Selesai" {{ $so_status == 'Selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-m btn-primary">Filter</button>
                                    </div>

                                    <div class="input-group input-group-m mb-0 mr-3 p-0" style="width: 25%;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search" value="{{ $table_search != null ? $table_search : '' }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('sale.create') }}" style="width: fit-content"
                                class="btn btn-m btn-success">Tambah Penjualan</a>
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
                                        <th>Total Penjualan</th>
                                        <th>Status</th>
                                        <th>Status Pembayaran</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale_orders as $so)
                                        <tr id="tr_{{ $so->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_code_{{ $so->id }}">{{ $so->code }}</td>
                                            <td>
                                                {{ $so->date }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($so->total_price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                @if ($so->status == 'Selesai')
                                                    <label class="badge bg-success">{{ $so->status }}</label>
                                                @else
                                                    <label class="badge bg-warning">{{ $so->status }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($so->payment_status == 'Lunas')
                                                    <label class="badge bg-success">{{ $so->payment_status }}</label>
                                                @else
                                                    <label class="badge bg-warning">{{ $so->payment_status }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('sale.show', $so->id) }}"
                                                    class="btn btn-sm btn-info ml-0 mr-0" id="btnShow" onclick=""><i
                                                        class="fas fa-eye"></i></button>
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
