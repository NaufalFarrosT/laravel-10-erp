<div class="modal-header">
    <h4 class="modal-title">Kofirmasi Hapus Data Toko</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <P> Apakah anda yakin untuk menghapus toko <b>{{ $store->name }}</b>?</P>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal"
        onclick="deleteWarehouseDataRemoveTR({{ $store->id }})">Hapus</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
