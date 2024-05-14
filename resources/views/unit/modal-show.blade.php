<div class="modal-header">
    <h4 class="modal-title">Detail Jabatan {{ $role->name }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th>Email</th>
                <th class="col-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>1.</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-warning"><i
                                class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                            onclick="showUser({{ $user->id }})"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
