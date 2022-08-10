var datatable;
$(() => {
    getRoles();
    datatable = $('#datatable-1').DataTable({
        ajax: '/api/role',
        columns: [
            { title: 'Name', data: 'name' },
            { title: 'Level', data: 'level', defaultContent: 0, sortable: 'desc' },
            {
                data: null,
                render: (data, type, row) => {
                    if (row.name=='Admin') {
                        return '';
                    }

                    return `
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-edit-role"><i class="fas fa-edit fa-fw"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>
                            `;
                }
            },
        ],
        order: [[1, 'desc']],
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
        $('#form-add-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
    });
    $('#modal-edit-role').on('show.bs.modal', (e) => {
        $('#form-edit-role button[type="submit"]').prop('disabled', false);
        $('#form-edit-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Update');
    });
    $('#datatable-1 tbody').on('click', '.btn-edit', function (e) {
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
            $('#form-add-role button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
        },
        success: (res) => {
            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'role berhasil ditambahkan.',
                });
                $('#form-add-role button.btn-submit').prop('disabled', false);
                $('#form-add-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
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
                $('#form-edit-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
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
                $('#form-edit-role button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
                $('#modal-edit-role button[data-dismiss="modal"]').trigger('click');
                datatable.ajax.reload();
            }
        }
    });
}