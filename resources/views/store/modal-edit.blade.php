<div class="modal-header">
    <h4 class="modal-title">Ubah Data Toko</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="">Nama Toko</label>
                <input type="text" class="form-control" id="eWarehouseName" name="eWarehouseName"
                    placeholder="Nama Toko" value="{{ $store->name }}">
            </div>
            <div class="form-group">
                <label for="">Alamat Toko</label>
                <input type="text" class="form-control" id="eWarehouseAddress" name="eWarehouseAddress"
                    placeholder="Alamat Toko" value="{{ $store->address }}">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal"
        onclick="saveDataUpdateTD({{ $store->id }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
