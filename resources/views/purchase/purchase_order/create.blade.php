@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Data Pemesanan Pembelian</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Pesanan Pembelian</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-6 mb-2">
                    <div class="input-group">
                        <input type="search" class="typeahead form-control form-control-lg" id="search"
                            placeholder="Cari Barang">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data Pemesanan Pembelian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Item</th>
                                    <th>Stok</th>
                                    <th style="">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                    <!-- form start -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        //Date picker
        $('#dobDateHelper').datetimepicker({
            format: 'YYYY/MM/DD'
        });

        $('#purchase_order_date').datetimepicker({
            format: 'YYYY/MM/DD'
        });

        var path = "{{ route('autocomplete') }}";

        $("#search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#search').val(ui.item.label);
                console.log(ui.item);

                var tr = "<tr id='tr_" + data.data.id + "'>" +
                    "<td>" + numberOfRow + "</td>" +
                    "<td id='td_name_" + data.data.id +
                    "'>" + name + "</td>" +
                    "<td>0</td>" +
                    "<td><button type='button' style='width: 60px' class='btn btn-sm btn-danger' onclick='deleteConfirmation(" +
                    data.data.id + ")'>Hapus</button>" +
                    "</td></tr>";

                $('.table-bordered tbody').append(tr);

                return false;
            }
        });
    </script>
@endsection
