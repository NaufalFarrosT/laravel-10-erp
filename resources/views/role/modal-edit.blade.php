<div class="modal-header">
    <h4 class="modal-title">Ubah Data Jabatan</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="">Nama Jabatan</label>
                <input type="text" class="form-control" id="eName" name="eName" placeholder="Nama Jabatan"
                    value="{{ $data->name }}">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveDataUpdateTD({{ $data->id }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
