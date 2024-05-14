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
                        <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Penjualan</h3>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                    style="height: 31px; width: fit-content;">
                                    <label for="dateRange" class="mb-0 mr-2">Tanggal:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mt-2" id="dateRange" name="dateRange">
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center mr-3 m-0 p-0"
                                    style="height: 31px; width: fit-content;">
                                    <label for="statusSelect" class="mb-0 mr-2">Status:</label>
                                    <div class="input-group">
                                        <select class="custom-select mt-2" id="statusSelect">
                                            <option value="">All</option>
                                            <option value="">Proses</option>
                                            <option value="">Selesai</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="card-tools">
                                    <div class="input-group input-group-m" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('sale.create') }}" style="width: fit-content"
                                    class="btn btn-m btn-success ml-3">Tambah Penjualan</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive p-0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Kasir</th>
                                        <th>Total Penjualan</th>
                                        <th>Pembayaran</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale_orders as $so)
                                        <tr id="tr_{{ $so->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_id_{{ $so->id }}">{{ $so->id }}</td>
                                            <td>
                                                {{ $so->date }}
                                            </td>
                                            <td></td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($so->total_price, 0, ',', '.');
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $so->supplier->name }}
                                            </td>
                                            <td>
                                                <label class="bg-info color-palette">{{ $so->item_receive_status }}</label>
                                            </td>
                                            <td>
                                                <label class="bg-info color-palette">{{ $so->payment_status }}</label>
                                            </td>
                                            <td>
                                                <a href="{{ route('purchase.show', $so->id) }}"
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
        $(function() {
            // Create date inputs with date range picker functionality
            $('#dateRange').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                startDate: '01-01-2021',
                endDate: '31-12-2021',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });
        });
    </script>
@endsection
