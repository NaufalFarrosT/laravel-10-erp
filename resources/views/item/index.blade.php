@extends('layouts.adminlte')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-content">

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Data Item</h3>

                        {{-- <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Item</h3>

                            <div class="d-flex flex-wrap justify-content-between">

                                <div class="card-tools mr-2">
                                    <form id="filterForm" class="flex-fill" method="GET"
                                        action="{{ route('item.index') }}">
                                        <div class="input-group input-group-m" style="width: 300px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search"
                                                value="{{ $table_search != null ? $table_search : '' }}">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <a href="{{ route('item.create') }}" class="btn btn-sm btn-success">Tambah
                                    Item</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="container ml-0 mb-2 pl-0">
                            <a href="{{ route('item.create') }}" class="btn btn-m btn-success">Tambah
                                Item</a>
                        </div>

                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Item</th>
                                    <th>Stok</th>
                                    <th style="">Satuan</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr id="tr_{{ $item->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $item->id }}">{{ $item->name }}</td>
                                        <td>
                                            {{ $item->stock }}
                                        </td>
                                        <td>
                                            {{ $item->unit->name }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnShow"
                                                onclick="show({{ $item->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="location.href='{{ route('item.edit', $item->id) }}'">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteItemConfirmation({{ $item->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $items->links() }}
                        </ul>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        // $(function() {
        //     $("#dataTable").DataTable();
        // });
        // $("#dataTable").DataTable();

        function show(id) {
            $.ajax({
                type: "GET",
                url: `item/${id}`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert("Error");
                },
            });
        }

        function deleteItemConfirmation(id) {
            $.ajax({
                type: "GET",
                url: `item/${id}/DeleteConfirmation`,
                success: function(response) {
                    $("#modal-content").html(response.msg);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                    alert('Error');
                }
            });
        }

        function deleteItemDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `item/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(response) {
                    if (response.status == "Success") {
                        $("#tr_" + id).remove();
                        toastr.success(response.msg);
                    } else {
                        alert(response.msg);
                    }
                },
            });
        }

        function showData(id) {
            $.ajax({
                type: "GET",
                url: `item/${id}`,
                success: function(response) {
                    //console.log(data.users);
                    $("#modal-content").html(response.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert("Error");
                },
            });
        }
    </script>
@endsection
