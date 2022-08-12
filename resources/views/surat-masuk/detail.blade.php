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
                    <div class="col-4" id="nomor_surat">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Tanggal Surat
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4" id="tanggal_surat">
                        12/12/1999
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Perihal Surat
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4" id="perihal_surat">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Jenis Surat Masuk
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4" id="jenis_surat_masuk">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Tanggal Upload
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-4" id="tanggal_upload">
                    </div>
                </div>

                <div style="bottom: 20px;position: absolute;" id="button-action">
                    <!-- <button type="button" class="btn btn-primary" onclick="processSurat()">Proses Surat</button>
                    <button type="button" class="btn btn-success" onclick="openModalDisposisi()">Disposisi
                        Surat</button> -->
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
                            <div class="timeline-steps aos-init aos-animate" data-aos="fade-up" id="container-step">
                                <!-- <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2003">
                                        <p class="h6 text-muted mb-4 mb-lg-4"><i>Surat Masuk</i></p>

                                        <div class="inner-circle-active"></div>
                                        <p class="h6 mt-3 mb-1">Bone Fletcher</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0"><i>Operator</i></p>
                                        <p class="h7 text-muted mb-0 mb-lg-0">Jun 6, 2022</p>

                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2004">
                                        <p class="h6 text-muted mb-4 mb-lg-4"><i>Disposisi 1</i></p>

                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">Bone Fletcher</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0"><i>Ka OPD</i></p>
                                        <p class="h7 text-muted mb-0 mb-lg-0">Jun 6, 2022</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2004">
                                        <p class="h6 text-muted mb-4 mb-lg-4"><i>Disposisi 2</i></p>

                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">Bone Fletcher</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0"><i>Ka OPD</i></p>
                                        <p class="h7 text-muted mb-0 mb-lg-0">Jun 6, 2022</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2004">
                                        <p class="h6 text-muted mb-4 mb-lg-4"><i>Disposisi 3</i></p>

                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">Bone Fletcher</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0"><i>Ka OPD</i></p>
                                        <p class="h7 text-muted mb-0 mb-lg-0">Jun 6, 2022</p>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover"
                                        data-placement="top" title=""
                                        data-content="And here's some amazing content. It's very engaging. Right?"
                                        data-original-title="2004">
                                        <p class="h6 text-muted mb-4 mb-lg-4"><i>Disposisi 2</i></p>

                                        <div class="inner-circle"></div>
                                        <p class="h6 mt-3 mb-1">Bone Fletcher</p>
                                        <p class="h6 text-muted mb-0 mb-lg-0"><i>Ka OPD</i></p>
                                        <p class="h7 text-muted mb-0 mb-lg-0">Jun 6, 2022</p>
                                    </div>
                                </div> -->
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
                <button type="button" class="btn btn-success" onclick="disposisiSurat()">Disposisi Surat</button>
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
@push('js')
<script src="https://adminlte.io/themes/v3/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
const id_surat = "<?php echo $id_surat ?>";
const user_role = "<?php echo $user_role ?>";
const user_id = "<?php echo $id_user ?>";



$(() => {
    getDetailSuratMasuk()
    getTrackingList()
});

function getDetailSuratMasuk() {
    $.ajax({
        url: '/api/surat-masuk/detail',
        method: 'get',
        data: {
            id_surat
        },
        success: (res) => {
            $("#button-action").html('')
            if (res.transaction) {
                $("#iframe-preview-pdf").attr('src', res.data.link_file)
                $("#nomor_surat").text(res.data.nomor_surat)
                $("#perihal_surat").text(res.data.perihal_surat)
                $("#tanggal_surat").text(res.data.tanggal_surat)
                $("#jenis_surat_masuk").text(res.data.jenis_surat_masuk)
                $("#tanggal_upload").text(res.data.created_date)

                if (res.data.is_proses != 1 && res.data.is_disposisi != 1 && res.data.assign_to ==
                    user_id) {
                    const btnAction =
                        ' <button type="button" class="btn btn-primary" onclick="processSurat()">Proses Surat</button>' +
                        '<button type="button" class="btn btn-success" onclick="openModalDisposisi()" style="margin-left:16px">Disposisi' +
                        'Surat</button>';

                    $("#button-action").append(btnAction)


                }


            }
        }
    })
}

function processSurat() {

    Swal.fire({
        title: "Are you sure?",
        text: "Apakah anda yakin akan memproses Surat ini ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/api/surat-masuk/proses-surat',
                method: 'post',
                data: {
                    user_id: user_id,
                    id_surat: id_surat,

                },
                success: (res) => {
                    if (res.transaction) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Surat Masuk Diproses',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                getDetailSuratMasuk()
                                getTrackingList()

                                $("#disposisiModal").modal('hide')
                            }
                        });
                    }
                }
            })
        }
        console.log(result, 'halo')
    })
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
            if (res.transaction) {
                $("#list_disposisi_assign").html('')
                $.each(res.data, (k, v) => {
                    var list = '<option value="' + v.id + '">' + v.name + '</option>';

                    $("#list_disposisi_assign").append(list)
                })
            }
            console.log(res)
        }
    })
}

function getTrackingList() {
    $.ajax({
        url: '/api/surat-masuk/get-tracking',
        method: 'get',
        data: {
            id_surat
        },
        success: (res) => {
            if (res.transaction) {
                $("#container-step").html('')
                var selesai = false;
                // const last_index = res.data.length - 1
                // console.log(res.data.length)
                $.each(res.data, (k, v) => {
                    selesai = v.status == 'Selesai' ? true : false
                    var status = v.proses == 1 ? 'Proses' : v.status
                    // const active = k == last_index ? 'inner-circle-active' : 'inner-circle'
                    const step = '<div class="timeline-step">' +
                        '<div class="timeline-content" >' +
                        '<p class="h6 text-muted mb-4 mb-lg-4"><i>' + status + '</i></p>' +
                        '<div class="inner-circle-active"></div>' +
                        '<p class="h6 mt-3 mb-1">' + v.name + '</p>' +
                        '<p class="h6 text-muted mb-0 mb-lg-0"><i>' + v.role + '</i></p>' +
                        '<p class="h7 text-muted mb-0 mb-lg-0">' + v.date + '</p>' +
                        '</div>' +
                        '</div>';

                    $("#container-step").append(step)

                })

                if (selesai == false) {
                    const step = '<div class="timeline-step">' +
                        '<div class="timeline-content" >' +
                        '<p class="h6 text-muted mb-4 mb-lg-4"><i>Selesai</i></p>' +
                        '<div class="inner-circle' +
                        '"></div>' +
                        '<p class="h6 mt-3 mb-1"></p>' +
                        '<p class="h6 text-muted mb-0 mb-lg-0"><i></i></p>' +
                        '<p class="h7 text-muted mb-0 mb-lg-0"></p>' +
                        '</div>' +
                        '</div>';

                    $("#container-step").append(step)
                }

            }
        }
    })
}

function disposisiSurat() {
    var id_disposisi = $("#list_disposisi_assign").val()

    $.ajax({
        url: '/api/surat-masuk/disposisi-surat',
        method: 'post',
        data: {
            assign_to: id_disposisi,
            id_surat: id_surat,
            user_id: user_id
        },
        success: (res) => {
            if (res.transaction) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Surat Masuk berhasil Disposisi',
                }).then((result) => {
                    if (result.isConfirmed) {
                        getDetailSuratMasuk()
                        getTrackingList()
                    }
                });
            }
        }
    })
}
</script>
@endpush