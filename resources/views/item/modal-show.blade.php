<div class="modal-header">
    <h4 class="modal-title">Detail Barang {{ $item->name }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Gudang</th>
                <th>Stok</th>
                <th class="col-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($item->warehouses as $item_warehouse)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item_warehouse->warehouse->name }}</td>
                    <td>{{ $item_warehouse->stock }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
