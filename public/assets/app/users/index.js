var datatable;
$(() => {
    getRoles();
    datatable = $('#datatable-1').DataTable({
        ajax: '/api/user',
        columns: [
            { title: 'NIP', data: 'nip', defaultContent: '' },
            { title: 'Nama', data: 'name' },
            { title: 'Email', data: 'email' },
            { title: 'Jabatan', data: 'jabatan', defaultContent: '' },
            { title: 'Role', data: 'role_name' },
            {
                title: 'Pemaraf',
                data: 'is_pemaraf',
                render: (data, type, row) => {
                    return (data === 1) ? '<i class="fas fa-check-circle fa-fw text-success"></i>' : '<i class="fas fa-times-circle fa-fw text-danger"></i>';
                }
            },
            {
                title: 'Penandatangan',
                data: 'is_pettd',
                render: (data, type, row) => {
                    return (data === 1) ? '<i class="fas fa-check-circle fa-fw text-success"></i>' : '<i class="fas fa-times-circle fa-fw text-danger"></i>';
                }
            },
            {
                title: 'Action',
                data: null,
                sortable: false,
                render: (data, type, row) => {
                    return `
                        <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-edit-user"><i class="fas fa-edit fa-fw"></i></button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>`;
                }
            },
        ]
    });

    $('#form-add-user').validate({
        rules: {
            nip: {
                required: true,
                number: true,
                minlength: 18,
                maxlength: 18,
            },
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            nip: {
                required: "Please enter a NIP",
                number: "Please enter a valid NIP"
            },
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            // console.log($(form).attr('name'));
            addUser($(form));
        }
    });

    $('#form-edit-user').validate({
        rules: {
            nip: {
                required: true,
                number: true,
                minlength: 18,
                maxlength: 18,
            },
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            nip: {
                required: "Please enter a NIP",
                number: "Please enter a valid NIP"
            },
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            const user_id = parseInt($(this.currentForm).find('input[name="id"]').val());
            editUser($(form), user_id);
        }
    });

    // $('#form-add-user').on('submit', (e)=>{
    //     e.preventDefault();
    //     addUser($(e.currentTarget));
    // });
    // $('#form-edit-user').on('submit', (e) => {
    //     e.preventDefault();
    //     const user_id = parseInt($(e.currentTarget).find('input[name="id"]').val());
    //     editUser($(e.currentTarget), user_id);
    // });
    $('#modal-add-user').on('show.bs.modal', (e) => {
        $('#form-add-user button[type="submit"]').prop('disabled', false);
        $('#form-add-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
    });
    $('#modal-edit-user').on('show.bs.modal', (e) => {
        $('#form-edit-user button[type="submit"]').prop('disabled', false);
        $('#form-edit-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Update');
    });
    $('#datatable-1 tbody').on('click', '.btn-edit', function (e) {
        const data = datatable.row($(this).parents('tr')).data();
        // console.log(data);
        $('#form-edit-user .btn-submit').attr('data-id', data.id);
        $('#form-edit-user input[name="id"]').val(data.id);
        $('#form-edit-user input[name="nip"]').val(data.nip);
        $('#form-edit-user input[name="name"]').val(data.name);
        $('#form-edit-user input[name="jabatan"]').val(data.jabatan);
        $('#form-edit-user input[name="email"]').val(data.email);
        $('#form-edit-user input[name="password"]').val(data.password);
        $('#form-edit-user input[name="is_pemaraf"]').prop('checked', (data.is_pemaraf == 1));
        $('#form-edit-user input[name="is_pettd"]').prop('checked', (data.is_pettd == 1));
        $('#form-edit-user select[name="role"]').val(data.role_id);
    });
    $('#datatable-1 tbody').on('click', '.btn-delete', (e) => {
        const user_id = parseInt($(e.currentTarget).data('id'));
        console.log(user_id);
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
                deleteUser(user_id);
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
function addUser(form) {
    $.ajax({
        url: '/api/user',
        method: 'post',
        data: form.serialize(),
        error: (err) => {
            // console.log(err.responseJSON.errors);

            $.each(err.responseJSON.errors, (k, v) => {
                console.log(form.find(`input[name="${k}"]`));
            });
        },
        success: (res) => {
            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'user berhasil ditambahkan.',
                });
                $('#form-add-user button.btn-submit').prop('disabled', false);
                $('#form-add-user button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
                $('#modal-add-user button[data-dismiss="modal"]').trigger('click');
                datatable.ajax.reload();
                form.trigger('reset');
            }
        }
    });
}
function editUser(form, user_id = 0) {
    $.ajax({
        url: `/api/user/${user_id}`,
        method: 'put',
        data: form.serialize(),
        beforeSend: () => {
            $('#form-edit-user button.btn-submit').prop('disabled', true);
            $('#form-edit-user button.btn-submit').removeClass('btn-primary').addClass('btn-secondary');
        },
        success: (res) => {
            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'user berhasil diupdate.',
                });
                $('#form-edit-user button.btn-submit').prop('disabled', false);
                $('#form-edit-user button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
                $('#modal-edit-user button[data-dismiss="modal"]').trigger('click');
                datatable.ajax.reload();
                form.trigger('reset');
            }
        }
    });
}
function deleteUser(user_id = 0) {
    $.ajax({
        url: `/api/user/${user_id}`,
        method: 'delete',
        beforeSend: () => {
            $('#form-edit-user button.btn-submit').prop('disabled', true);
            $('#form-edit-user button.btn-submit').removeClass('btn-primary').addClass('btn-secondary');
        },
        success: (res) => {
            if (res.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'user berhasil dihapus.'
                })
                $('#form-edit-user button.btn-submit').prop('disabled', false);
                $('#form-edit-user button.btn-submit').removeClass('btn-secondary').addClass('btn-success').text('Success');
                $('#modal-edit-user button[data-dismiss="modal"]').trigger('click');
                datatable.ajax.reload();
            }
        }
    });
}