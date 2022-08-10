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
@php
$user = auth()->user();
$user_role = auth()->user()->role_id;

$id_user = $user->id;
@endphp

@section('content')

@if($user_role==2)
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
                <form id="form-surat-masuk" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Tanggal
                                </div>
                                <div class="col-6">
                                    <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat"
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
                                    <select name="jenis_surat_masuk" class="form-select"
                                        aria-label="Default select example" id="jenis_surat_masuk">
                                        <option value="1">Penting</option>
                                        <option value="0">Biasa</option>
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
                                    <input name="asal_surat" type="text" class="form-control" id="asal_surat"
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
                                    <input name="file" class="form-control" type="file" id="formFile">
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
                                    <input name="perihal_surat" type="text" class="form-control" id="perihal_surat"
                                        placeholder="Masukan Perihal">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Ditugaskan ke
                                </div>
                                <div class="col-6">
                                    <select name="ditugaskan_ke" class="form-select" aria-label="Default select example"
                                        id="ditugaskan_ke">
                                        <!-- <option value="penting">Penting</option>
                                        <option value="biasa">Biasa</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Nomor
                                </div>
                                <div class="col-6">
                                    <input name="nomor_surat" type="text" class="form-control" id="nomor_surat"
                                        placeholder="Masukan Nomor">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">

                                </div>
                                <div class="col-6  d-flex align-items-end flex-column">
                                    <button type="submit" class="btn btn-primary btn-submit-surat-masuk">Submit</button>

                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

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
<script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
const user_id = "<?php echo $id_user ?>"

$(() => {
    getPenugasan()
    getListSurat()
    $('#form-surat-masuk').on('submit', (e) => {
        e.preventDefault();
        submitSurat($(e.currentTarget));
    });



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

function getListSurat() {
    // var dataa = [{
    //         'urgensi': 'Penting',
    //         'perihal': 'Surat Tugas',
    //         'tanggal': 'Aug 4, 2022',
    //         'action': 'liat file',
    //         'status': 'Masuk Ka OPD',
    //         'delete': 'delete'
    //     }

    // ]

    var datatable = $('#datatable-surat').DataTable({
        ajax: '/api/surat-masuk',
        orderCellsTop: true,
        bDestroy: true,
        columns: [{
            data: 'jenis_surat_masuk'
        }, {
            data: 'perihal_surat'
        }, {
            data: 'tanggal_surat'
        }, {
            data: 'action',
            render: (data, type, row) => {

                return '<a href="' + row.link_file + '" target="_blank">Liat File</a>'
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

}

function submitSurat(form) {
    var formData = new FormData();
    formData.append('tanggal_surat', $("#tanggal_surat").val())
    formData.append('jenis_surat_masuk', $("#jenis_surat_masuk").val())
    formData.append('asal_surat', $("#asal_surat").val())
    formData.append('perihal_surat', $("#perihal_surat").val())
    formData.append('ditugaskan_ke', $("#ditugaskan_ke").val())
    formData.append('nomor_surat', $("#nomor_surat").val())

    formData.append('file', $('input[type=file]')[0].files[0]);
    formData.append('user_id', user_id);



    $.ajax({
        url: '/api/surat-masuk',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
            const spinner = ' <div class = "ml-2 spinner-border text-light spinner-grow-sm"' +
                'role = "status" id = "spinner-loading" ><span class = "sr-only"id = "spinner-loading" > Loading... < /span> < /div > ';

            $(".btn-submit-surat-masuk").append(spinner)

        },
        error: () => {

        },
        complete: () => {
            $("#spinner-loading").remove()
        },
        success: (res) => {

            if (res.transaction) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Surat Masuk Berhasil di Tugaskan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#form-surat-masuk").trigger("reset");
                        getListSurat()
                    }
                });
            }
            console.log(res)
        }
    })
}

function getPenugasan() {

    $.ajax({
        url: '/api/user',
        method: 'get',
        data: {
            role_id: 3
        },
        success: (res) => {

            $.each(res.data, (k, v) => {
                $('#ditugaskan_ke').append(`<option value="${v.id}">${v.name}</option>`);

            });

            console.log(res, 'res')
        }
    })
}
</script>
@endpush