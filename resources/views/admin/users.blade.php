@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1 class="m-0 text-dark">User Management</h1>
@stop

@push('css')
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">User list</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-user">Add user</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <table id="datatable-1" class="table table-striped table-bordered" style="width:100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th>Pemaraf</th>
                            <th>Penandatangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New user</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-add-user" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip" class="form-control" placeholder="NIP">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Atribut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_pemaraf" value="1">
                                <label class="form-check-label">Pemaraf</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_pettd" value="1">
                                <label class="form-check-label">Penandatangan</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="">Role</label>
                            <select class="form-control list-role" name="role">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary btn-submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit user</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit-user" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip" class="form-control" id="nip" placeholder="NIP">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Jabatan">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Atribut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_pemaraf" name="is_pemaraf" value="1">
                                <label class="form-check-label">Pemaraf</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_pettd" name="is_pettd" value="1">
                                <label class="form-check-label">Penandatangan</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="">Role</label>
                            <select class="form-control list-role" name="role" id="role">
                            </select>
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
    <script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        var datatable;
        $(() => {

            getRoles();

            datatable = $('#datatable-1').DataTable({
                ajax: '/api/user',
                columns: [
                    { data: 'nip', defaultContent: `123` },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'jabatan' },
                    { data: 'role_name' },
                    {
                        data: 'is_pemaraf',
                        render: (data, type, row)=>{
                            return (data===1) ? '<i class="fas fa-check-circle fa-fw text-success"></i>' : '<i class="fas fa-times-circle fa-fw text-danger"></i>';
                        }
                    },
                    { 
                        data: 'is_pettd',
                        render: (data, type, row)=>{
                            return (data===1) ? '<i class="fas fa-check-circle fa-fw text-success"></i>' : '<i class="fas fa-times-circle fa-fw text-danger"></i>';
                        }
                    },
                    {
                        data: null,
                        render: (data, type, row)=>{
                            return `
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-edit-user"><i class="fas fa-edit fa-fw"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>`;
                        }
                    },
                ]
            });

            $('#form-add-user').on('submit', (e)=>{
                e.preventDefault();
                addUser($(e.currentTarget));
            });
            $('#form-edit-user').on('submit', (e)=>{
                e.preventDefault();

                const user_id = parseInt($(e.currentTarget).find('input[name="id"]').val());
                editUser($(e.currentTarget), user_id);
            });

            $('#modal-add-user').on('show.bs.modal', (e)=>{
                $('#form-add-user button[type="submit"]').prop('disabled', false);
                $('#form-add-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
            });
            $('#modal-edit-user').on('show.bs.modal', (e)=>{
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
                $('#form-edit-user input[name="is_pemaraf"]').prop('checked', (data.is_pemaraf==1));
                $('#form-edit-user input[name="is_pettd"]').prop('checked', (data.is_pettd==1));
                $('#form-edit-user select[name="role"]').val(data.role_id);
            });

            $('#datatable-1 tbody').on('click', '.btn-delete', (e)=>{
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

        function getRoles(){
            $.ajax({
                url: '/api/role',
                success: (res)=>{
                    if (res.status==1) {
                        $.each(res.data, (k,v)=>{
                            $('.list-role').append(`<option value="${v.id}">${v.name}</option>`);
                        });
                    } 
                }
            });
        }

        function addUser(form){

            $.ajax({
                url: '/api/user',
                method: 'post',
                data: form.serialize(),
                success: (res)=>{

                    if (res.status==1) {
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

        function editUser(form, user_id=0){
            $.ajax({
                url: `/api/user/${user_id}`,
                method: 'put',
                data: form.serialize(),
                beforeSend: ()=>{
                    $('#form-edit-user button.btn-submit').prop('disabled', true);
                    $('#form-edit-user button.btn-submit').removeClass('btn-primary').addClass('btn-secondary');
                },
                success: (res)=>{

                    if (res.status==1) {
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

        function deleteUser(user_id=0){
            $.ajax({
                url: `/api/user/${user_id}`,
                method: 'delete',
                beforeSend: ()=>{
                    $('#form-edit-user button.btn-submit').prop('disabled', true);
                    $('#form-edit-user button.btn-submit').removeClass('btn-primary').addClass('btn-secondary');
                },
                success: (res)=>{

                    if (res.status==1) {
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
    </script>
@endpush
