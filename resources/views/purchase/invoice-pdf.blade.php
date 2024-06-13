<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .invoice-header {
            background-color: #f7f7f7;
            padding: 20px;
            margin-bottom: 20px;
        }

        .invoice-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }

        .invoice-total {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container mt-2">
        <div class="invoice-header text-center">
            <h1>POS KU</h1>
        </div>
        <div class="row">
            <div class="col text-center">
                <h2><u>Nota Pembelian</u></h2>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td class="w-75">
                        <strong>Nomor Nota:</strong> {{ $purchase_order->code }} <br>
                        <strong>Nama Pemasok:</strong> {{ $purchase_order->supplier->name }}<br>
                        <strong>Tanggal:</strong> {{ $purchase_order->date }}<br>
                    </td>
                    {{-- <td class="w-25">
                        @if ($purchase_order->payment_status == 'Lunas')
                            <Strong>Status: </Strong><br>
                            <button class="btn btn-sm btn-success align-self-center">Lunas</button>
                        @else
                            <Strong>Status: </Strong><button class="btn btn-sm btn-warning">Belum Lunas</button>
                        @endif
                    </td> --}}
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive mt-4">
        <table class="table invoice-table">
            <thead class="thead-light">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase_order->purchase_details as $pd)
                    <tr id="tr_{{ $pd->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td id="td_name_{{ $pd->id }}">{{ $pd->item->name }}</td>
                        <td class="text-right">
                            @php
                                echo 'Rp ' . number_format($pd->price, 0, ',', '.');
                            @endphp
                        </td>
                        <td>
                            {{ $pd->qty }} {{ $pd->item->unit->name }}
                        </td>
                        <td class="text-right">
                            @php
                                echo 'Rp ' . number_format($pd->discount, 0, ',', '.');
                            @endphp
                        </td>
                        <td class="text-right">
                            @php
                                echo 'Rp ' . number_format($pd->total_price, 0, ',', '.');
                            @endphp
                        </td>
                    </tr>
                @endforeach
                @if ($purchase_order->payment_status == 'Lunas')
                    <tr>
                        <td colspan="5" class="text-right">Total: </strong></td>
                        <td class="text-right">
                            {{ 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Terbayar:</strong></td>
                        <td class="text-right">
                            {{ 'Rp ' . number_format($total_purchase_payment, 0, ',', '.') }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-right"><strong>Total:</strong></td>
                        <td class="text-right">
                            {{ 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Terbayar:</strong></td>
                        <td class="text-right">
                            {{ 'Rp ' . number_format($total_purchase_payment, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><strong><u>Sisa Bayar:</u></strong></td>
                        <td class="text-right">
                            {{ 'Rp ' . number_format($purchase_order->total_price - $total_purchase_payment, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- <div class="container p-0">
        <div class="row mt-4 p-0">
            <div class="col-md-6">
                <!-- Kolom kiri kosong untuk keperluan tambahan -->
            </div>
            <div class="col-md-6 text-right">
                <div class="invoice-total">
                    @if ($purchase_order->payment_status == 'Lunas')
                        <strong>Diskon :</strong> {{ 'Rp ' . number_format($purchase_order->discount, 0, ',', '.') }}</br>
                        <strong>Total: </strong>{{ 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.') }}</br>
                    @else
                        <p>Diskon : {{ 'Rp ' . number_format($purchase_order->discount, 0, ',', '.') }}</p>
                        <p>Terbayar: {{ 'Rp ' . number_format($total_sale_payment, 0, ',', '.') }}</p>
                        <p>Total: {{ 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <div class="text-center mt-3">
        <p>Terima kasih!</p>
    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
