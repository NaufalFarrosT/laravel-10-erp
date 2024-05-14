<div class="modal-header">
    <h4 class="modal-title">Kofirmasi Hapus Data Penerimaan Barang</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <P> Apakah anda yakin untuk menghapus <b>{{ $data->name }}</b>?</P>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal"
        onclick="deleteDataRemoveTR({{ $data->id }}, '{{ $route }}', '{{ $table_name }}')">Hapus</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
