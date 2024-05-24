<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content" id="">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pemasok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pemasok</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Pemasok" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Alamat" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                    id="btnSubmit" onclick="storeSupplierData()">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
