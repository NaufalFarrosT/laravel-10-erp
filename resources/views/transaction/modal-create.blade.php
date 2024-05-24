<div class="modal-header">
    <h4 class="modal-title">Tambah {{ $transaction_type == 1 ? 'Pendapatan' : 'Pengeluaran' }}</h4>
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
                <label for="" class="col-form-label">Akun</label>
                <div class="">
                    <select class="custom-select" id="account_id" name="account_id">
                        @foreach ($sub_accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            <div class="form-group">
                <label for="">Total {{ $transaction_type == 1 ? 'Pendapatan' : 'Pengeluaran' }}</label>
                <input type="text" class="form-control" id="amount" name="amount"
                    placeholder="Masukkan jumlah dalam Rupiah" onkeyup="inputFormatRupiah(this, 'Rp. ')"
                    onclick="inputFormatRupiah(this, 'Rp. ')" required>
            </div>
            <div class="form-group">
                <label for="">Informasi Tambahan</label>
                <input type="text" class="form-control" id="information" name="information"
                    placeholder="Informasi Tambahan">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal"
        onclick="storeData({{ $transaction_type }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
