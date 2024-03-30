@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Penerimaan Barang</h1>
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

                <!-- Detil Pemesanan Pembelian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Penerimaan Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pb-0">
                        <div class="row table-responsive p-0">
                            <table id="itemDataTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px"><input type="checkbox" name="select-all" id="select-all"
                                                checked />
                                        </th>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Barang</th>
                                        <th style="width: 30px">Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_order->purchase_details as $pd)
                                        <tr id="tr_{{ $pd->id }}">
                                            <td><input type="checkbox" class="checkbox" name="checkbox" id="checkbox"
                                                    checked /></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                            <td>
                                                <input type='number' name='price[]' id='price' min='1'
                                                    max="{{ $pd->qty }}" class='form-control'
                                                    value="{{ $pd->qty }}" />
                                            </td>
                                            <td>
                                                {{ $pd->item->unit->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo 'Rp ' . number_format($pd->price, 0, ',', '.');
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
                        <button type="submit" class="btn btn-info" id="btnSubmit">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-default float-right"> Batal</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection
@section('javascript-function')
    <script>
        // count rows
        function checkAllCheckbox() {
            var rowCount = $('#itemDataTable tbody tr').length;
            var checkboxCount = $('.checkbox:checked').length;
            console.log(rowCount)
            console.log(checkboxCount)

            if (checkboxCount === rowCount) {
                $('#select-all').prop('checked', true)
            } else {
                $('#select-all').prop('checked', false)
            }
        }


        // Listen for click on toggle checkbox
        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $('#btnSubmit').prop('disabled', !$('.checkbox:checked').length);
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $('#btnSubmit').prop('disabled', !$('.checkbox:checked').length);
            }
        });

        // Disable button if no checkbox checked
        $('.checkbox').click(function() {
            $('#btnSubmit').prop('disabled', !$('.checkbox:checked').length);
            checkAllCheckbox();
        });
    </script>
@endsection
