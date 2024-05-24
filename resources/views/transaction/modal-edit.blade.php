<div class="modal-header">
    <h4 class="modal-title">Ubah {{ $transaction->transaction_type_id == 1 ? 'Pendapatan' : 'Pengeluaran' }}</h4>
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
                    type="date" value="{{ $transaction->date }}" id="eDatePicker" name="eDatePicker" />
            </div>
            <div class="form-group">
                <label for="" class="col-form-label">Akun</label>
                <div class="">
                    <select class="custom-select" id="eAccount_id" name="eAccount_id">
                        @foreach ($sub_accounts as $account)
                            @if ($account->id == $transaction->sub_account_id)
                                <option value="{{ $account->id }}" selected>{{ $account->name }}</option>
                            @else
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Total
                        {{ $transaction->transaction_type_id == 1 ? 'Pendapatan' : 'Pengeluaran' }}</label>
                    <input type="text" class="form-control" id="eAmount" name="eAmount"
                        placeholder="Masukkan jumlah dalam Rupiah" onkeyup="inputFormatRupiah(this, 'Rp. ')"
                        onclick="inputFormatRupiah(this, 'Rp. ')"
                        value="{{ 'Rp. '.number_format($transaction->amount, 0, ',', '.') }}" required>
                </div>
                <div class="form-group">
                    <label for="">Informasi Tambahan</label>
                    <input type="text" class="form-control" id="eInformation" name="eInformation"
                        placeholder="Informasi Tambahan" value="{{ $transaction->information }}">
                </div>
            </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal"
        onclick="saveDataUpdateTD({{ $transaction->id }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
