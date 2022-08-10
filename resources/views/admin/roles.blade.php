@extends('adminlte::page')

@section('title', 'Role Management')

@section('content_header')
<h1 class="m-0 text-dark">Role Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Role list</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-role">Add
                            role</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-1" class="table table-striped table-bordered" style="width:100%"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add-role" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <input type="number" id="level" name="level" class="form-control" placeholder="Level">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-role" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <input type="number" id="level" name="level" class="form-control" placeholder="Level">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop

@push('js')
<script>
var datatable;
$(() => {

    getRoles();

    datatable = $('#datatable-1').DataTable({
        ajax: '/api/role',
        columns: [{
                data: 'name'
            },
            {
                data: 'level'
            },
            {
                data: null,
                render: (data, type, row) => {
                    return `
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-edit-role"><i class="fas fa-edit fa-fw"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>
                            `;
                }
            },
        ]
    });

    $('#form-add-role').on('submit', (e) => {
        e.preventDefault();
        addRole($(e.currentTarget));
    });
    $('#form-edit-role').on('submit', (e) => {
        e.preventDefault();

        const role_id = parseInt($(e.currentTarget).find('input[name="id"]').val());
        editRole($(e.currentTarget), role_id);
    });

    $('#modal-add-role').on('show.bs.modal', (e) => {
        $('#form-add-role button[type="submit"]').prop('disabled', false);
        $('#form-add-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass(
            'btn-primary').text('Create');
    });
    $('#modal-edit-role').on('show.bs.modal', (e) => {
        $('#form-edit-role button[type="submit"]').prop('disabled', false);
        $('#form-edit-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass(
            'btn-primary').text('Update');
    });

    $('#datatable-1 tbody').on('click', '.btn-edit', function(e) {

        const data = datatable.row($(this).parents('tr')).data();
        console.log(data);
        $('#form-edit-role .btn-submit').attr('data-id', data.id);
        $('#form-edit-role input[name="id"]').val(data.id);
        $('#form-edit-role input[name="name"]').val(data.name);
        $('#form-edit-role input[name="level"]').val(data.level);
    });

    $('#datatable-1 tbody').on('click', '.btn-delete', (e) => {
        const role_id = parseInt($(e.currentTarget).data('id'));
        console.log(role_id);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRole(role_id);
            }
        })
    })

});

function getRoles() {
    $.ajax({
        url: '/api/role',
        success: (res) => {
            if (res.status == 1) {
                $.each(res.data, (k, v) => {
                    $('.list-role').append(`<option value="${v.id}">${v.name}</option>`);
                });
            }
        }
    });
}

function addRole(form) {

    $.ajax({
        url: '/api/role',
        method: 'post',
        data: form.serialize(),
        error: (e) => {
            $('#form-add-role button[type="submit"]').prop('disabled', false);
            $('#form-add-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass(
                'btn-primary').text('Create');
        },
        success: (res) => {
            console.log(res, 'halo')
            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'role berhasil ditambahkan.',
                });
                $('#form-add-role button.btn-submit').prop('disabled', false);
                $('#form-add-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success')
                    .text('Success');

                $("#name").val('')
                $("#level").val('')

                $('#modal-add-role button[data-dismiss="modal"]').trigger('click');

                datatable.ajax.reload();
                form.trigger('reset');
            }
        }
    });

}

function editRole(form, role_id = 0) {
    $.ajax({
        url: `/api/role/${role_id}`,
        method: 'put',
        data: form.serialize(),
        success: (res) => {

            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'role berhasil diupdate.'
                })
                $('#form-edit-role button.btn-submit').prop('disabled', false);
                $('#form-edit-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success')
                    .text('Success');

                $('#modal-edit-role button[data-dismiss="modal"]').trigger('click');

                datatable.ajax.reload();
                form.trigger('reset');
            }

        }
    });

}

function deleteRole(role_id = 0) {
    $.ajax({
        url: `/api/role/${role_id}`,
        method: 'delete',
        beforeSend: () => {
            $('#form-edit-role button.btn-submit').prop('disabled', true);
            $('#form-edit-role button.btn-submit').removeClass('btn-primary').addClass('btn-secondary');
        },
        success: (res) => {

            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'role berhasil dihapus.'
                })
                $('#form-edit-role button.btn-submit').prop('disabled', false);
                $('#form-edit-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success')
                    .text('Success');

                $('#modal-edit-role button[data-dismiss="modal"]').trigger('click');

                datatable.ajax.reload();
            }

        }
    });

}
</script>
@endpush