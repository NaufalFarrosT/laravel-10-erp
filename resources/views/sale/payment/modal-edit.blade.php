<div class="modal-header">
    <h4 class="modal-title">Ubah Pembayaran</h4>
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
                    type="date" value="{{ $sale_payment->date }}" id="eDatePicker" name="eDatePicker" />
            </div>
            <div class="form-group">
                <label for="Total Pembayaran">Total Pembayaran</label>
                <input type="text" class="form-control" id="ePayment_amount" name="ePayment_amount"
                    value="{{ 'Rp. ' . number_format($sale_payment->amount, 0, ',', '.') }}"
                    placeholder="Masukkan jumlah dalam Rupiah" onkeyup="inputFormatRupiah(this, 'Rp. ')"
                    onclick="inputFormatRupiah(this, 'Rp. ')" required>
            </div>

            <div class="form-group">
                <label for="" class="col-form-label">Akun</label>
                <div class="">
                    <select class="custom-select" id="eAccount_id" name="eAccount_id">
                        @foreach ($sub_accounts as $account)
                            @if ($account->id == $sale_payment->sub_account_id)
                                <option value="{{ $account->id }}" selected>{{ $account->name }}</option>
                            @else
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal"
        onclick="updatePaymentData({{ $sale_payment->id }})">Ubah</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
