<div class="modal-header">
    <h4 class="modal-title">Ubah Data Supplier</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="">Nama Supplier</label>
                <input type="text" class="form-control" id="eName" name="eName" placeholder="Nama Supplier"
                    value="{{ $supplier->name }}">
            </div>
            <div class="form-group">
                <label for="">Nama Supplier</label>
                <input type="text" class="form-control" id="eAddress" name="eAddress" placeholder="Alamat"
                    value="{{ $supplier->address }}">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveSupplierDataUpdateTD({{ $supplier->id }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
