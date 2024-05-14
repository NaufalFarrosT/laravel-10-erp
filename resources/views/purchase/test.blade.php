<div class="modal-header">
    <h4 class="modal-title">Pembayaran</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Tanggal</label>
                <input class="form-control form-control-inline input-medium date-picker col-sm-6" size="16"
                    type="date" value="{{ date('Y-m-d') }}" id="datePicker" name="datePicker" />
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Total Pembayaran</label>
                @php
                    $formatted_total_price = 'Rp ' . number_format($purchase_order->total_price, 0, ',', '.');
                @endphp
                <input type="text" class="form-control" id="balance" name="balance" placeholder="Nominal"
                    value="{{ $formatted_total_price }}" required>
            </div>
            <div class="form-group">
                <label for="amountRupiah">Jumlah Rupiah</label>
                <input type="text" class="form-control" id="amountRupiah" name="amountRupiah" placeholder="Masukkan jumlah dalam Rupiah" onkeyup="formatRupiah(this, 'Rp. ')" onclick="formatRupiah(this, 'Rp. ')">
            </div>
            <script>
                function formatRupiah(angka, prefix){
                    var number_string = angka.value.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                    
                    if(ribuan){
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    
                    angka.value = prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                }
            </script>
            <div class="form-group">
                <label for="" class="col-form-label">Akun</label>
                <div class="">
                    <select class="custom-select" id="unit_id" name="unit_id">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="storePaymentData()">Bayar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>

