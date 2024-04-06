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
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-content">

                        </div>
                    </div>
                </div>

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
                            <table class="table table-bordered text-nowrap">
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

                                    <div id="item_receive_action">
                                        @if ($purchase_order->item_receive_status == 'SEMUA')
                                            <div class="row">
                                                <label for="">! Semua barang sudah diterima</label>
                                            </div>
                                        @else
                                            <div class="row">
                                                <a href="{{ route('purchase.createItemReceive', $purchase_order->id) }}"
                                                    style="width: fit-content" class="btn btn-sm btn-success">
                                                    Tambah Data Penerimaan Barang
                                                </a>
                                            </div><br>
                                        @endif
                                    </div>

                                    <div class="row table-responsive p-0">
                                        <table class="table table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Tanggal</th>
                                                    <th>Kode</th>
                                                    <th>Detail Item</th>
                                                    <th>Gudang</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase_order->item_receives as $ir)
                                                    <tr id="tr_item_receive_{{ $ir->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td id="td_date_{{ $ir->id }}">{{ $ir->date }}</td>
                                                        <td>
                                                            {{ $ir->id }}
                                                        </td>
                                                        <td>
                                                            @foreach ($ir->itemReceiveDetails as $ir_detail)
                                                                {{ $ir_detail->qty }} -
                                                                {{ $ir_detail->purchaseDetail->item->name }} </br>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            {{ $ir->warehouse->name }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="" class="btn btn-sm btn-warning mr-2"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <button class="btn btn-sm btn-danger"
                                                                    onclick="deleteConfirmationItemReceive({{ $ir->id }})"><i
                                                                        class="fas fa-trash-alt"></i></button>
                                                            </div>
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

@section('javascript-function')
    <script>
        function deleteConfirmationItemReceive(id) {
            $.ajax({
                type: "GET",
                url: `/purchase/item-receive-delete-confirmation/${id}`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                    alert('Error');
                }
            });
        }

        function deleteDataRemoveTR(id, route, tableName) {
            $.ajax({
                type: "DELETE",
                url: `/purchase/item-receive/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(data) {
                    if (data.status == "Success") {
                        $("#tr_" + tableName + "_" + id).remove();
                        toastr.success(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },
            });
        }
    </script>
@endsection
