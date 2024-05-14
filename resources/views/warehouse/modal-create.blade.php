<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content" id="">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Gudang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Gudang</label>
                            <input type="text" class="form-control" id="warehouseName" name="warehouseName"
                                placeholder="Nama Gudang" required>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat Gudang</label>
                            <input type="text" class="form-control" id="warehouseAddress" name="warehouseAddress"
                                placeholder="Alamat Gudang" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                    onclick="storeWarehouseData()">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
