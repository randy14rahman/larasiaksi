@extends('adminlte::page')
@section('title', 'Surat Masuk')

@section('content_header')
<h1 class="m-0 text-dark">Surat Masuk</h1>
@stop

@push('css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <h4> Buat Surat</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Tanggal
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Masukan Tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Jenis
                            </div>
                            <div class="col-6">
                                <select class="form-select" aria-label="Default select example">
                                    <option value="penting">Penting</option>
                                    <option value="biasa">Biasa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Asal
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Masukan Asal">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Upload File
                            </div>
                            <div class="col-6">
                                <input class="form-control" type="file" id="formFile">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Perihal
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Masukan Perihal">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">

                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                Nomor
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Masukan Perihal">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">

                            </div>
                            <div class="col-6  d-flex align-items-end flex-column">
                                <button type="button" class="btn btn-primary">Submit</button>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <h4> List Surat</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-surat" class="table" style="width:100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Urgensi</th>
                            <th>Perihal</th>
                            <th>Tanggal Surat</th>
                            <th>File</th>
                            <th>Status Dokumen</th>
                            <th>Action</th>
                        </tr>
                        <tr class="filte">
                            <th>
                                <div>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Penting</option>
                                        <option value="biasa">Biasa</option>
                                    </select>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Item 1 </option>
                                        <option value="biasa">Item 2</option>
                                    </select>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">1 Agustus 2022</option>
                                        <option value="biasa">1 Agustus 2022</option>
                                    </select>
                                </div>
                            </th>
                            <th></th>
                            <th>
                                <div>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Masuk Ka Opd</option>
                                        <option value="biasa">Process</option>
                                    </select>
                                </div>
                            </th>
                            <th></th>
                        </tr>

                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <h4> List Disposisi</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-disposisi" class="table" style="width:100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Posisi Dokumen</th>
                            <th>Jabatan</th>
                            <th>Disposisi Dari</th>
                            <th>Jabatan Pendisposisi</th>
                            <th>Status</th>
                            <th>Tgl Disposisi</th>
                            <th>No Surat</th>

                        </tr>


                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>



@stop
@push('js')
<script>
$(() => {

    var dataa = [{
            'urgensi': 'Penting',
            'perihal': 'Surat Tugas',
            'tanggal': 'Aug 4, 2022',
            'action': 'liat file',
            'status': 'Masuk Ka OPD',
            'delete': 'delete'
        }

    ]
    var data_disposisi = [{
            'posisi': 'Andi',
            'jabatan': 'Eselon 3',
            'from': 'Robinson',
            'jabatan_pen': 'KA OPD',
            'status': 'process',
            'tgl': 'Aug 1 , 2022',
            'no': '12345'
        }

    ]
    datatable = $('#datatable-surat').DataTable({
        data: dataa,
        orderCellsTop: true,
        columns: [{
            data: 'urgensi'
        }, {
            data: 'perihal'
        }, {
            data: 'tanggal'
        }, {
            data: 'action',
            render: () => {
                return '<a href="google.com">Liat File</a>'
            }
        }, {
            data: 'status',
            render: (data, type, row) => {
                return `<div><span class="badge text-bg-primary" style="background-color:#0d6efd">Masuk Ka OPD</span></div>`
            }
        }, {
            data: 'delete',
            render: (data, type, row) => {
                return `<button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>`
            }
        }]


    });
    datatable = $('#datatable-disposisi').DataTable({
        data: data_disposisi,
        orderCellsTop: true,
        columns: [{
            data: 'posisi'
        }, {
            data: 'jabatan'
        }, {
            data: 'from'
        }, {
            data: 'jabatan_pen'
        }, {
            data: 'status',
            render: (data, type, row) => {
                return `<div><span class="badge text-bg-primary" style="background-color:#198754">Process</span></div>`
            }
        }, {
            data: 'tgl'
        }, {
            data: 'no'
        }]


    });

    // $('#form-add-user').on('submit', (e)=>{
    //     e.preventDefault();
    //     addUser($(e.currentTarget));
    // });
    // $('#form-edit-user').on('submit', (e)=>{
    //     e.preventDefault();

    //     const user_id = parseInt($(e.currentTarget).find('input[name="id"]').val());
    //     editUser($(e.currentTarget), user_id);
    // });

    // $('#modal-add-user').on('show.bs.modal', (e)=>{
    //     $('#form-add-user button[type="submit"]').prop('disabled', false);
    //     $('#form-add-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
    // });
    // $('#modal-edit-user').on('show.bs.modal', (e)=>{
    //     $('#form-edit-user button[type="submit"]').prop('disabled', false);
    //     $('#form-edit-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Update');
    // });
    // $('#datatable-1 tbody').on('click', '.btn-edit', function (e) {

    //     const data = datatable.row($(this).parents('tr')).data();
    //     // console.log(data);
    //     $('#form-edit-user .btn-submit').attr('data-id', data.id);
    //     $('#form-edit-user input[name="id"]').val(data.id);
    //     $('#form-edit-user input[name="nip"]').val(data.nip);
    //     $('#form-edit-user input[name="name"]').val(data.name);
    //     $('#form-edit-user input[name="jabatan"]').val(data.jabatan);
    //     $('#form-edit-user input[name="email"]').val(data.email);
    //     $('#form-edit-user input[name="password"]').val(data.password);
    //     $('#form-edit-user input[name="is_pemaraf"]').prop('checked', (data.is_pemaraf==1));
    //     $('#form-edit-user input[name="is_pettd"]').prop('checked', (data.is_pettd==1));
    //     $('#form-edit-user select[name="role"]').val(data.role_id);
    // });

    // $('#datatable-1 tbody').on('click', '.btn-delete', (e)=>{
    //     const user_id = parseInt($(e.currentTarget).data('id'));
    //     console.log(user_id);
    //     Swal.fire({
    //     title: 'Are you sure?',
    //     text: "You won't be able to revert this!",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     cancelButtonColor: '#3085d6',
    //     confirmButtonColor: '#d33',
    //     confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             deleteUser(user_id);
    //         }
    //     })
    // })

});
</script>
@endpush