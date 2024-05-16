@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Data Pembelian</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- form start -->
                <form class="form-horizontal" id="purchase_detail" name="purchase_detail" method="POST"
                    action="{{ route('purchase.store') }}">
                    @csrf
                    <div class="p-1">
                        <div class="form-group row">
                            <label for="supplier" class="col-sm-1 col-form-label">Pemasok</label>
                            <div class="col-sm-3">
                                <input type="search" class="typeahead form-control input-medium" id="supplier_search"
                                    name="supplier_search" placeholder="Cari Pemasok">
                                <input type="hidden" id="supplier_id" name="supplier_id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Tanggal</label>
                            <div class="col-sm-2">
                                <input class="form-control form-control-inline input-medium date-picker" size="16"
                                    type="date" value="" id="datePicker" name="datePicker" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="col-sm-1 col-form-label">Total </label>
                        <label id="displayTotal" name="displayTotal" class="bold col-sm-3"
                            style="margin-left: 10px;font-size: large;">RP 0</label>
                        <input type="hidden" id="total" name="total">
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Pembelian</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-6 mb-2 p-0">
                                <div class="input-group">
                                    <input type="search" class="typeahead form-control form-control-lg" id="item_search"
                                        placeholder="Cari Barang">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Item</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Potongan</th>
                                            <th>Jumlah Biaya</th>
                                            <th style="width: 15px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreItem">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="submit" class="btn btn-info">Simpan</button>
                            <a href="{{ url()->previous() }}" class="btn btn-default float-right"> Batal</a>
                        </div>
                        <!-- /.card-footer -->

                    </div>
                    <!-- /.card -->
                </form>
                <!-- form end -->
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

        // Set date to nowdate
        document.getElementById('datePicker').valueAsDate = new Date();

        function countTotalItemPrice(tr) {
            // Price
            let price = tr.find('.price');
            let priceValue = price.val().replace(/,/g, '');
            let formattedPrice = changeNumberWithThousandSeparator(priceValue)
            price.val(function() {
                return (priceValue === 0) ?
                    "0" :
                    formattedPrice;
            })

            // Quantity
            let qty = tr.find('.quantity');
            let qtyValue = qty.val().replace(/,/g, '');
            let formattedQty = changeNumberWithThousandSeparator(qtyValue)
            qty.val(function() {
                return (qtyValue === 0) ?
                    "" :
                    formattedQty;
            })

            // Discount
            let discount = tr.find('.discount');
            let discountValue = discount.val().replace(/,/g, '');
            let formattedDiscount = changeNumberWithThousandSeparator(discountValue)
            discount.val(function() {
                return (discountValue === 0) ?
                    "0" :
                    formattedDiscount;
            })

            // Total Price per Item
            let totalPriceValue = (qtyValue * priceValue) - discountValue;
            let displayTotalPrice = tr.find('.display_total_price_per_item');
            tr.find('#total_price_per_item').val(totalPriceValue);

            displayTotalPrice.text(function() {
                return (totalPriceValue === 0) ?
                    "" :
                    totalPriceValue.toLocaleString();
            })
        };

        // Count total price by summarize total price each item
        function countGrandTotal() {
            let total = 0;
            $(".display_total_price_per_item").each(function(i, e) {
                let amount = $(this).text().replaceAll(",", "");
                amount = parseInt(amount);

                //let amount = $(this).val() - 0;
                total += amount;
            });

            let rupiahFormat = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(total);

            $("#displayTotal").html(rupiahFormat);
            $("#total").val(total);
        }

        function changeNumberWithThousandSeparator(number) {
            number = number.replace(/\D/g, ''); // Remove non-numeric characters
            number = Number(number).toLocaleString(); // Add thousand separator
            return number
        }

        // Count total price after keyup or click
        $(".addMoreItem").delegate(".quantity, .price, .discount", "keyup click", function() {
            let tr = $(this).parent().parent();

            countTotalItemPrice(tr);

            countGrandTotal();
        });

        let autoCompleteSupplierPath = "{{ route('purchase.supplier.autoComplete') }}";
        $("#supplier_search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: autoCompleteSupplierPath,
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
                $('#supplier_search').val(ui.item.value);
                $('#supplier_id').val(ui.item.id);
                console.log(ui.item);

                return false;
            }
        });

        let autoCompleteItemPath = "{{ route('purchase.item.autoComplete') }}";
        let numberOfRow = $(".table-bordered tr").length - 0;
        $("#item_search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: autoCompleteItemPath,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        console.log(data)
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#item_search').val("");
                // console.log(ui.item);

                if ($('#tr_' + ui.item.id).length) {
                    tr_item = $('#tr_' + ui.item.id)

                    tr_item_quantity = parseInt(tr_item.find('#quantity').val());
                    new_quantity = tr_item_quantity + 1;
                    tr_item.find('#quantity').val(new_quantity);

                    countTotalItemPrice(tr_item);
                } else {
                    let tr = "<tr id='tr_" + ui.item.id + "'>" +
                        "<input type='hidden' id='itemId' name='itemId[]' value=" + ui.item.id + ">" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + ui.item.id + "'>" +
                        ui.item.value + "</td>" +
                        "<td>" +
                        "<input type='text' class='form-control price' id='price' name='price[]' value=" + ui
                        .item.price.toLocaleString() + "></td>" +
                        "<td>" +
                        "<input type='number' name='quantity[]' id='quantity'" +
                        "min='1' class='form-control quantity' value='1' required/>" +
                        "</td>" +

                        "<td><input type='text' name='discount[]' id='discount'" +
                        "min='0' class='form-control discount' value='0' required/></td>" +

                        "<td><label id='display_total_price_per_item' name='display_total_price_per_item[]' class='form-control display_total_price_per_item'>" +
                        ui.item.price.toLocaleString() + "</label>" +
                        "<input type='hidden' id='total_price_per_item' name='total_price_per_item[]' value=" +
                        ui
                        .item.price + "></td>" +
                        "<td><button type='button' style='' class='btn btn-danger btn-sm delete' onclick='deleteConfirmation(" +
                        ui.item.id + ")'><i class='fas fa-trash-alt'></i></button>" +
                        "</td></tr>";

                    $('.table-bordered tbody').append(tr);
                }

                countGrandTotal();
                return false;
            }
        });

        $(".addMoreItem").delegate(".delete", "click", function() {
            $(this).parent().parent().remove();
            countGrandTotal();
        });
    </script>
@endsection
