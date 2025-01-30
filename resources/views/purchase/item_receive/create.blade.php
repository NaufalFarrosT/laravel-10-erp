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
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ route('item-receive.store') }}">
                @csrf
                <div class="container-fluid">
                    <div class="form-group row mb-0">
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
                            <input class="form-control form-control-inline input-medium date-picker" size="16"
                                type="date" value="" id="datePicker" name="datePicker" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-1 col-form-label">Toko</label>
                        <div class="col-sm-3">
                            <select class="custom-select" id="store_id" name="store_id">
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- <i class="fas fa-eye"></i> Pemesanan Pembelian -->
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
                                            <th style="width: 10px"><input type="checkbox" id="select-all" checked />
                                            </th>
                                            <th style="width: 10px">#</th>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 100px">Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" class="form-control" name="purchase_order_id"
                                            id="purchase_order_id" value="{{ $purchase_order->id }}">
                                        @foreach ($purchase_details as $pd)
                                            @if ($pd->qty != 0)
                                                <tr id="tr_{{ $pd->id }}">
                                                    <td>
                                                        <input type="hidden" class="form-control" name="selectedData[]"
                                                            id="selectedData" value="true">
                                                        <input type="hidden" class="form-control"
                                                            name="purchase_detail_id[]" id="purchase_detail_id"
                                                            value="{{ $pd->id }}">
                                                        <input type="checkbox" class="form-control checkbox" id="checkbox"
                                                            value="true" checked />
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $pd->item_id }}
                                                    </td>
                                                    <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                                                    <td>
                                                        <input type='number' name='qty[]' id='qty' min='1'
                                                            max="{{ $pd->qty }}" class='form-control'
                                                            value="{{ $pd->qty }}" />
                                                    </td>

                                                    <td>
                                                        {{ $pd->item->unit->name }}
                                                    </td>
                                                    {{-- <td>
                                                    @php
                                                        echo 'Rp ' . number_format($pd->price, 0, ',', '.');
                                                    @endphp
                                                </td> --}}
                                                </tr>
                                            @endif
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
            </form>
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

        // Set date to nowdate
        document.getElementById('datePicker').valueAsDate = new Date();

        // count rows
        function checkAllCheckbox() {
            var rowCount = $('#itemDataTable tbody tr').length;
            var checkboxCount = $('.checkbox:checked').length;

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

            $(this).parent().find('#selectedData').val($(this).is(':checked'));
        });
    </script>
@endsection
