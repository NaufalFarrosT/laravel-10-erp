<div class="modal-header">
    <h4 class="modal-title">Detail User</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="text-center">
        <img class="profile-user-img img-fluid" src="{{ asset('assets/dist/img/user4-128x128.jpg') }}"
            alt="User profile picture">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nama Lengkap</td>
                <td>
                    <b>: {{ $user->fullname }}</b>
                </td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>
                    <b>:
                        <?php
                        echo date('d-m-Y', strtotime($user->dob));
                        ?>
                    </b>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>
                    <b>: {{ $user->address }}</b>
                </td>
            </tr>
            <tr>
                <td>Kelamin</td>
                <td>
                    <b>: {{ $user->gender }}</b>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <b>: {{ $user->email }}</b>
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>
                    <b>: {{ $user->role->name }}</b>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
