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
                        <h3 class="mb-0">Data Satuan</h3>

                        {{-- <div class="d-flex flex-wrap justify-content-between">
                            <h3 class="mb-0">Data Satuan</h3>

                            <div class="d-flex flex-wrap justify-content-between">

                                <div class="card-tools mr-2">
                                    <form id="filterForm" class="flex-fill" method="GET"
                                        action="{{ route('unit.index') }}">
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

                                <button type="button" style="" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-create">Tambah
                                    Satuan</button>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Modal Start -->
                    @include('unit/modal-create')
                    <!-- Modal End -->

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="container ml-0 mb-2 pl-0">
                            <button type="button" class="btn btn-m btn-success" data-toggle="modal"
                                data-target="#modal-create">Tambah Satuan</button>
                        </div>
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Satuan</th>
                                    <th style="width: 130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr id="tr_{{ $unit->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="td_name_{{ $unit->id }}">{{ $unit->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editUnitData({{ $unit->id }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteConfirmation({{ $unit->id }})"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('javascript-function')
    <script>
        function storeUnitData() {
            var input_name = $("#inputName").val();
            var numberOfRow = $(".table-bordered tr").length - 0;

            $.ajax({
                type: "POST",
                url: `unit`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: input_name
                },
                success: function(response) {
                    toastr.success(response.msg);
                    var tr = "<tr id='tr_" + response.data.id + "'>" +
                        "<td>" + numberOfRow + "</td>" +
                        "<td id='td_name_" + response.data.id +
                        "'>" + input_name + "</td>" +
                        "<td><button type='button' class='btn btn-sm btn-warning' onclick='editUnitData(" +
                        response.data.id + ")'><i class='fas fa-edit'></i></button>" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteConfirmation(" +
                        response.data.id + ")'><i class='fas fa-trash-alt '></i></button>" +
                        "</td></tr>";

                    $('.table-bordered tbody').append(tr);
                    $('#inputName').val("");
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                }
            });
        }

        function editUnitData(id) {
            $.ajax({
                type: "GET",
                url: `unit/${id}/edit`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function saveUnitDataUpdateTD(id) {
            var eName = $("#eName").val();
            $.ajax({
                type: "PUT",
                url: `unit/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    name: eName
                },
                success: function(data) {
                    $("#td_name_" + id).html(eName);
                    toastr.success(data.msg);
                },
                error: function(err) {
                    alert(err);
                },
            });
        }

        function deleteConfirmation(id) {
            $.ajax({
                type: "GET",
                url: `unit/${id}/DeleteConfirmation`,
                success: function(data) {
                    $("#modal-content").html(data.msg);
                    $("#modal-default").modal('show');
                },
                error: function(xhr) {
                    console.log((xhr.responseJSON.errors));
                    alert('Error');
                }
            });
        }

        function deleteUnitDataRemoveTR(id) {
            $.ajax({
                type: "DELETE",
                url: `unit/${id}`,
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(data) {
                    if (data.status == "Success") {
                        $("#tr_" + id).remove();
                        toastr.success(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },
            });
        }
    </script>
@endsection
