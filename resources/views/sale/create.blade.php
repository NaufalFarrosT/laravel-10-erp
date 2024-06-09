@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- form start -->
                <form class="form-horizontal" id="sale_detail" name="sale_detail" method="POST"
                    action="{{ route('sale.store') }}">
                    @csrf

                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Penjualan</h3>
                        </div>

                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-sm-4">
                                    <div class="form-group col-sm-8 p-0">
                                        <label class="col-form-label">Pelanggan</label>
                                        <input id="customer_search" type="text" class="form-control" value="guest"
                                            name="customer_name">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group col-sm-6 p-0">
                                        <label class="col-form-label">Tanggal</label>
                                        <input class="form-control form-control-inline input-medium date-picker"
                                            size="16" type="date" value="" id="datePicker"
                                            name="datePicker" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="col col-form-label">TOTAL</label>
                                        <label id="displayTotal" name="displayTotal" class="bold"
                                            style="margin-left: 10px;font-size: large;">RP 0</label>
                                        <input type="hidden" id="total" name="total">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Data Barang</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-sm-4 mb-2 p-0">
                                <div class="input-group">
                                    <input type="search" class="typeahead form-control form-control-m" id="item_search"
                                        placeholder="Cari Barang">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-m btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Item</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Potongan</th>
                                            <th>Subtotal</th>
                                            <th style="width: 15px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreItem">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer clearfix">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url()->previous() }}" class="btn btn-default float-right"> Batal</a>
                        </div>
                    </div>
                </form>
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

        let autoCompleteCustomerPath = "{{ route('sale.customer.autoComplete') }}";
        $("#customer_search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: autoCompleteCustomerPath,
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
                $('#customer_search').val(ui.item.value);
                $('#customer_id').val(ui.item.id);
                console.log(ui.item);

                return false;
            }
        });

        let autoCompleteItemPath = "{{ route('sale.item.autoComplete') }}";
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

                if ($('#tr_' + ui.item.id).length) {
                    $tr_item = $('#tr_' + ui.item.id);

                    $tr_item_quantity = parseInt($tr_item.find('#quantity').val());

                    // Check quantity if item quantity same with stock give alert
                    if ($tr_item_quantity == ui.item.stock) {
                        alert("melebihi batas stock");
                    } else {
                        $new_quantity = $tr_item_quantity + 1;
                        $tr_item.find('#quantity').val($new_quantity);

                        countTotalItemPrice($tr_item);
                    }
                } else {
                    let tr = "<tr id='tr_" + ui.item.id + "'>" +
                        "<input type='hidden' id='itemId' name='itemId[]' value=" + ui.item.id + ">" +
                        "<input type='hidden' id='warehouseItemId' name='warehouseItemId[]' value=" + ui.item
                        .warehouse_item_id + ">" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + ui.item.id + "'>" +
                        ui.item.value + "</td>" +
                        "<td>" +
                        "<input type='text' class='form-control price' id='price' name='price[]' value=" + ui
                        .item.selling_price.toLocaleString() + "></td>" +
                        "<td><input type='number' name='quantity[]' id='quantity'" +
                        "min='1' max='" + ui.item.stock +
                        "' class='form-control quantity' value='1' required/><span>Stok: " + ui.item.stock +
                        "</span>" + "</td>" +

                        "<td><input type='text' name='discount[]' id='discount'" +
                        "min='0' class='form-control discount' value='0' required/></td>" +

                        "<td><label id='display_total_price_per_item' name='display_total_price_per_item[]' class='form-control display_total_price_per_item'>" +
                        ui.item.selling_price.toLocaleString() + "</label>" +
                        "<input type='hidden' id='total_price_per_item' name='total_price_per_item[]' value=" +
                        ui.item.selling_price + "></td>" +
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
