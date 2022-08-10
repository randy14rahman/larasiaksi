@extends('adminlte::page')
@section('title_prefix', 'Surat Keluar -')

@section('content_header')
    <h1 class="m-0 text-dark">Surat Keluar</h1>
@stop

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
                                    Pemaraf 1
                                </div>
                                <div class="col-6">
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Andi</option>
                                        <option value="biasa">Bambang</option>
                                    </select>
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
                                        placeholder="Masukan Asal">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Pemaraf 2
                                </div>
                                <div class="col-6">
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Andi</option>
                                        <option value="biasa">Bambang</option>
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
                                    <input type="number" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Masukan Nomor Surat">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Penanda Tangan
                                </div>
                                <div class="col-6">
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="penting">Andi</option>
                                        <option value="biasa">Bambang</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    Judul
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Masukan Judul">
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
                        <div class="col-6"></div>
                        <div class="col-5 d-flex align-items-end flex-column">
                            <button type="button" class="btn btn-primary">Submit</button>

                        </div>
                        <div class="col-1"></div>


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
                    <table id="datatable-surat-keluar" class="table" style="width:100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Judul</th>
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
@stop
@push('js')
<script>
$(() => {
    var dataa = [{
        'judul': 'Perjalanan Dinas',
        'perihal': 'Surat Tugas',
        'tanggal': 'Aug 4, 2022',
        'action': 'liat file',
        'status': 'Diproses',
        'delete': 'delete'
    }]

    datatable = $('#datatable-surat-keluar').DataTable({
        data: dataa,
        orderCellsTop: true,
        columns: [{
            data: 'judul'
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
                return `<div><span class="badge text-bg-primary" style="background-color:#28a745">Proses</span></div>`
            }
        }, {
            data: 'delete',
            render: (data, type, row) => {
                return `<button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>`
            }
        }]


    });


})
</script>
@endpush