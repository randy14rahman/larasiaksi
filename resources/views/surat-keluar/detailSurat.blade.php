@php
use Zend\Debug\Debug;
//Debug::dump($data);

$file = ($data->signed_surat??$data->link_surat)!="" ? ($data->signed_surat??$data->link_surat) : '/file-not-found';
//Debug::dump($file);//die;
@endphp

@extends('adminlte::page')
@section('title_prefix', 'Detail Surat Keluar -')

@push('css')
<style>
.error.invalid-feedback {
    display: none !important;
}
</style>
@endpush

@section('content_header')
<h1 class="m-0 text-dark">Detail Surat Keluar - {{$data->perihal_surat}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <iframe src="/ViewerJS/#{{$data->signed_surat??$data->link_surat}}" class="w-100" frameborder="0" height="750"
                    id="display-pdf"></iframe>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="form-group row mb-0">
                    <label for="" class="col-4">Tanggal Surat</label>
                    <div class="col-8">
                        : {{$data->tanggal_surat}}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="" class="col-4">Perihal</label>
                    <div class="col-8">
                        : {{$data->perihal_surat}}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="" class="col-4">Nomor Surat</label>
                    <div class="col-8">
                        : {{$data->nomor_surat}}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="" class="col-4">Judul 
                    
                    
                    
                    </label>
                    <div class="col-8">
                        : {{$data->judul_surat}}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="" class="col-4">Dibuat oleh</label>
                    <div class="col-8">
                        :
                        {{$data->created_by_name}}<br>&nbsp;&nbsp;{{date_format(date_create($data->created_at), 'l, d F Y H:i')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 pemaraf1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center float-none text-center">
                            Pemaraf<br>{{$data->pemaraf1->jabatan}}</h3>
                    </div>
                    <div class="card-body text-center" style="height: 100px;">
                        @if (auth()->id()==$data->pemaraf1->id && (int)$data->is_paraf1==0 && $data->is_reject==NULL)
                        <a href="#" class="btn btn-app bg-primary m-0"
                            onclick="event.preventDefault(); setParaf1({{$data->id}});">Paraf,<br>Klik disini</a>
                        <a href="#" class="btn btn-app bg-warning m-0"
                            onclick="event.preventDefault(); rejectSurat({{$data->id}});">Reject Surat</a>
                        @elseif($data->is_paraf1==1)
                        <span class="badge badge-success mt-3">Sudah
                            diparaf<br>{{date_format(date_create($data->paraf1_date), 'l, d F Y H:i')}}</span>
                        @elseif($data->is_reject==1 && (int)$data->pemaraf1->id==(int)$data->rejected)

                        <img src="/assets/image/reject.png" style="width: 70px;" />
                        @else
                        <span class="badge badge-danger mt-3">Belum diparaf</span>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        {{$data->pemaraf1->name}}
                        <br>
                        {{$data->pemaraf1->nip}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 pemaraf2{{($data->pemaraf2)==''? ' d-none' :'' }}">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center float-none text-center">
                            Pemaraf<br>{{$data->pemaraf2->jabatan??''}}</h3>
                    </div>
                    <div class="card-body text-center" style="height: 100px;">
                        @if (auth()->id()==($data->pemaraf2->id??0) && (int)$data->is_paraf2==0 &&
                        $data->is_reject==NULL)
                        <a href="#" class="btn btn-app bg-primary m-0"
                            onclick="event.preventDefault(); setParaf2({{$data->id}});">Paraf,<br>Klik disini</a>
                        <a href="#" class="btn btn-app bg-warning m-0"
                            onclick="event.preventDefault(); rejectSurat({{$data->id}});">Reject Surat</a>
                        @elseif($data->is_paraf2==1)
                        <span class="badge badge-success mt-3">Sudah
                            diparaf<br>{{date_format(date_create($data->paraf2_date??''), 'l, d F Y H:i')}}</span>
                        @elseif($data->is_reject==1 && ($data->pemaraf2->id??0)==(int)$data->rejected)
                        <img src="/assets/image/reject.png" style="width: 70px;" />
                        @else
                        <span class="badge badge-danger mt-3">Belum diparaf</span>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        {{$data->pemaraf2->name??''}}
                        <br>
                        {{$data->pemaraf2->nip??''}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 pettd{{($data->pemaraf2)==''? '' :' offset-md-3' }}">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center float-none text-center">
                            Penandatangan<br>{{$data->pettd->jabatan}}</h3>
                    </div>
                    <div class="card-body text-center" style="height: 100px;" id="container-btn-ttd">

                        @if(auth()->id()==$data->pettd->id && (int)$data->is_ttd==0 && (is_null($data->is_paraf1) || (!is_null($data->pemaraf2) && is_null($data->is_paraf2))) &&
                        $data->is_reject==NULL)
                        <button type="button" class="btn btn-app bg-primary m-0"
                            onclick="event.preventDefault(); setTtd({{$data->id}});" disabled="disabled">Tandatangan,<br>Klik disini</button>
                            <a href="#" class="btn btn-app bg-warning m-0"
                            onclick="event.preventDefault(); rejectSurat({{$data->id}});">Reject Surat</a>
                        @elseif(auth()->id()==$data->pettd->id && (int)$data->is_ttd==0 &&
                        $data->is_reject==NULL)
                        <button type="button" class="btn btn-app bg-primary m-0"
                            onclick="event.preventDefault(); setTtd({{$data->id}});">Tandatangan,<br>Klik disini</button>
                            <a href="#" class="btn btn-app bg-warning m-0"
                            onclick="event.preventDefault(); rejectSurat({{$data->id}});">Reject Surat</a>
                        @elseif($data->is_ttd==1)
                        <span class="badge badge-success mt-3">Sudah
                            ditandatangan<br>{{date_format(date_create($data->ttd_date), 'l, d F Y H:i')}}</span>
                        @elseif($data->is_reject==1 && (int)$data->pettd->id==(int)$data->rejected)
                        <img src="/assets/image/reject.png" style="width: 70px;" />
                        @else
                        <span class="badge badge-danger mt-3">Belum ditandatangan</span>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        {{$data->pettd->name}}
                        <br>
                        {{$data->pettd->nip}}
                    </div>
                </div>
            </div>
        </div>
        @if($data->is_reject==1)
        <div class="card" id="card-table_disposisi">
            <div class="card-body p-0">
                <table class="table table-stripped" id="table-disposisi">
                    <thead>
                        <tr>
                            <th>Direject oleh</th>
                            <th>Tanggal Reject</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->rejected_by}}</td>
                            <td>{{$data->reject_date}}</td>
                            <td>
                                <span class="badge badge-danger">Rejected</span>
                            </td>
                            <td>
                                <span>
                                    {{$data->note_rejected}}
                                </span>
                            </td>


                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="modal fade" id="rejectSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="close-modal">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label">Catatan</label>
                    <textarea class="form-control" name="keterangan" id="selesai_keterangan" cols="30"
                        rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning btn-reject"
                    onclick="rejectSuratModal({{$data->id}})">Reject
                    Surat</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/downloadjs@1.4.7"></script>
<script src="https://unpkg.com/pdf-lib"></script>

<script>
const url_id = "<?php echo $data->link_surat  ?>"
</script>
<script src="/assets/app/surat-keluar/detail-surat.js"></script>
@endpush
