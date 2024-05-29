<div class="modal-header">
    <h4 class="modal-title">Detail Pemasok {{ $supplier->name }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>PO ID</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th class="col-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplier->purchase_orders as $po)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $po->code }}</td>
                    <td>{{ $po->date }}</td>
                    <td>{{ $po->status }}</td>
                    <td>
                        <a href="{{ route('purchase.show', $po->id) }}" class="btn btn-sm btn-primary"><i
                                class="fas fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
