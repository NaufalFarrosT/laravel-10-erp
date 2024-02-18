<div class="modal-header">
    <h4 class="modal-title">Ubah Data Unit</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="">Nama Unit</label>
                <input type="text" class="form-control" id="eName" name="eName" placeholder="Nama Unit"
                    value="{{ $unit->name }}">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveUnitDataUpdateTD({{ $unit->id }})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
