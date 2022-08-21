@extends('adminlte::page')
@section('title', 'Detail Surat Masuk')

@push('css')
    <style>
        .timeline-steps {
            display: flex;
            justify-content: center;
        }

        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem;
                margin-top: 50px
            }

            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem;
                margin-top: 50px
            }
        }

        .timeline-steps .timeline-content {
            width: 10rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: red
        }

        .timeline-steps .timeline-content .inner-circle-active {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #3b82f6
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: #C4C4C4;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }

        .timeline-steps .timeline-content .inner-circle-active:before {
            content: "";
            background-color: red;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }
    </style>
@endpush

@section('content_header')
<h1 class="m-0 text-dark">Detail Surat Masuk</h1>
@stop

@php
$user = auth()->user();
$user_role = auth()->user()->role_id;
$id_user = $user->id;
$id_surat = request()->route('id');
@endphp

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <div>
                            <h4> Tracking</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up" id="container-step">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="card">
                <div class="card-body p-0">
                    <iframe src="" id="iframe-preview-pdf" width="100%" style="height: 900px;" border="0"></iframe>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-body" style="display:flex;flex-direction:column;">
                    <div class="row">
                        <div class="col-3">
                            Nomor Surat
                        </div>
                        <div class="col-9" id="nomor_surat">: <span></span></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            Tanggal Surat
                        </div>
                        <div class="col-9" id="tanggal_surat">: <span></span></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            Perihal Surat
                        </div>
                        <div class="col-9" id="perihal_surat">: <span></span></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            Jenis Surat Masuk
                        </div>
                        <div class="col-9" id="jenis_surat_masuk">: <span></span></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            Dibuat oleh
                        </div>
                        <div class="col-9" id="tanggal_upload">: <span></span></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            Ditugaskan ke
                        </div>
                        <div class="col-9" id="assign_to">: <span></span></div>
                    </div>
                </div>
            </div>
            <div class="card d-none" id="card-table_disposisi">
                <div class="card-body p-0">
                    <table class="table table-stripped" id="table-disposisi">
                        <thead>
                            <tr>
                                <th>Disposisi dari</th>
                                <th>Disposisi ke</th>
                                <th>Tanggal disposisi</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="card d-none" id="card-table_proses">
                <div class="card-body p-0">
                    <table class="table table-stripped" id="table-proses">
                        <thead>
                            <tr>
                                <th>Pemroses</th>
                                <th>Tanggal Proses</th>
                                <th>Tanggal Selesai</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="card d-none" id="card-action">
                <div class="card-body">
                    <div id="button-action"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disposisiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Disposisi Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" id="close-modal">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Disposisi ke</label>
                        <select name="jenis_surat_masuk" class="form-control form-select mt-3" aria-label="Default select example" id="list_disposisi_assign"></select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Catatan</label>
                        <textarea class="form-control" name="keterangan" id="disposisi_keterangan" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="disposisiSurat()">Disposisi Surat</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="selesaiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Arsipkan Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" id="close-modal">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Catatan</label>
                        <textarea class="form-control" name="keterangan" id="selesai_keterangan" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="arsipkanSurat()">Arsipkan Surat</button>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
<script>
const id_surat = <?= $id_surat ?>;
const user_role = <?= $user_role ?>;
const user_id = <?= $id_user ?>;
</script>
<script src="/assets/app/surat-masuk/detail.js"></script>
@endpush