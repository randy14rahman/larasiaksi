@extends('adminlte::page')
@section('title', 'Detail Surat Masuk')

@section('content_header')
<h1 class="m-0 text-dark">Detail Surat Masuk</h1>
@stop

@push('css')

<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


@endpush
@php
$user = auth()->user();
$user_role = auth()->user()->role_id;
$id_user = $user->id;
$id_surat = request()->route('id');
@endphp

@section('content')
<div class="row">
    <div class="col-4">
        <div class="card">

            <div class="card-body" style="height: 650px;">
                <iframe src="" id="iframe-preview-pdf" width="100%" style="height: 600px;"></iframe>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <h4> Detail Surat Masuk</h4>
                    </div>
                </div>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;height: 590px;">
                <div class="row">
                    <div class="col-2">
                        Nomor Surat
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4">
                        12/12/1999
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Tanggal Surat
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4">
                        12/12/1999
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Perihal Surat
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4">
                        12/12/1999
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Jenis Surat Masuk
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4">
                        12/12/1999
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Tanggal Upload
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4">
                        12/12/1999
                    </div>
                </div>

                <div style="bottom: 20px;position: absolute;">
                    <button type="button" class="btn btn-primary" onclick="processSurat()">Proses Surat</button>
                    <button type="button" class="btn btn-success" onclick="openModalDisposisi()">Disposisi
                        Surat</button>
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
                        <h4> Tracking</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2003">
                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">2003</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0">Favland Founded</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2004">
                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">2004</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0">Launched Trello</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2005">
                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">2005</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0">Launched Messanger</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2010">
                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">2010</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0">Open New Branch</p>
                                    </div>
                                </div>
                                <div class="timeline-step mb-0">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2020">
                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">2020</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0">In Fortune 500</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>Disposisi Ke</div>
                <select name="jenis_surat_masuk" class="form-control form-select mt-3"
                    aria-label="Default select example" id="list_disposisi_assign">
                    <!-- <option value="1">Penting</option>
                    <option value="0">Biasa</option> -->
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Disposisi Surat</button>
            </div>
        </div>
    </div>
</div>




@stop
@push('css')
<style>
.timeline-steps {
    display: flex;
    justify-content: center;
    flex-wrap: wrap
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
        top: .3125rem
    }

    .timeline-steps .timeline-step:not(:first-child):before {
        content: "";
        display: block;
        border-top: .25rem dotted #3b82f6;
        width: 3.8125rem;
        position: absolute;
        right: 7.5rem;
        top: .3125rem
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
    background-color: #3b82f6
}

.timeline-steps .timeline-content .inner-circle:before {
    content: "";
    background-color: #3b82f6;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}
</style>
@endpush
@push('js')
<script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
const id_surat = "<?php echo $id_surat ?>";
const user_role = "<?php echo $user_role ?>"


$(() => {
    getDetailSuratMasuk()
});

function getDetailSuratMasuk() {
    $.ajax({
        url: '/api/surat-masuk/detail',
        method: 'get',
        data: {
            id_surat
        },
        success: (res) => {
            if (res.transaction) {
                $("#iframe-preview-pdf").attr('src', res.data.link_file)
            }
        }
    })
}

function processSurat() {
    console.log('process surat')
}

function openModalDisposisi() {
    getListDisposisiAssign();
    $("#disposisiModal").modal('show')
    console.log('disposisi surat')

}

function getListDisposisiAssign() {
    $.ajax({
        url: '/api/surat-masuk/list-disposisi-assign',
        method: 'get',
        data: {
            role_id: user_role
        },
        success: (res) => {
            console.log(res)
        }
    })
}
</script>
@endpush