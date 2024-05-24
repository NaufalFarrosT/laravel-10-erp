<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between">
            <h3 class="card-title">Data Penerimaan Barang</h3>
            <div id="item_receive_action" class="p-0 m-0">
                @if ($purchase_order->item_receive_status != 'Diterima')
                    <a href="{{ route('item-receive.createWithID', $purchase_order->id) }}" style="width: fit-content"
                        class="btn btn-sm btn-success ml-3">
                        Tambah Penerimaan Barang
                    </a>
                @endif
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body pb-0">
        <div class="row table-responsive p-0">
            <table class="table table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Detail Item</th>
                        <th>Gudang</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_order->item_receives as $ir)
                        <tr id="tr_item_receive_{{ $ir->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td id="td_date_{{ $ir->id }}">{{ $ir->date }}</td>
                            <td id="td_code_{{ $ir->id }}">{{ $ir->code }}</td>
                            <td>
                                @foreach ($ir->itemReceiveDetails as $ir_detail)
                                    {{ $ir_detail->qty }} -
                                    {{ $ir_detail->purchaseDetail->item->name }} </br>
                                @endforeach
                            </td>
                            <td>
                                {{ $ir->warehouse->name }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- <a href="{{ route('item-receive.edit', $purchase_order->id) }}" class="btn btn-sm btn-warning mr-2"><i
                                            class="fas fa-edit"></i></a> --}}
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteConfirmationItemReceive({{ $ir->id }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
    </div>
    <!-- /.card-footer -->
</div>
