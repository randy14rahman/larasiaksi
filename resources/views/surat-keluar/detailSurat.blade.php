@php
use Zend\Debug\Debug;
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
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <iframe src="{{$data->link_surat}}#toolbar=0" class="w-100" frameborder="0" height="750" id="display-pdf"></iframe>
                </div>
            </div>
        </div>
        <div class="col-5">
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
                        <label for="" class="col-4">Judul Surat</label>
                        <div class="col-8">
                            : {{$data->judul_surat}}
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="" class="col-4">Dibuat oleh</label>
                        <div class="col-8">
                            : {{$data->created_by_name}}<br>&nbsp;&nbsp;{{date_format(date_create($data->created_at), 'l, d F Y H:i')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 pemaraf1">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center float-none text-center">Pemaraf<br>{{$data->pemaraf1->jabatan}}</h3>
                        </div>
                        <div class="card-body text-center" style="height: 100px;">
                            @if (auth()->id()==$data->pemaraf1->id && (int)$data->is_paraf1==0)
                                <a href="#" class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setParaf1({{$data->id}});">Paraf,<br>Klik disini</a>
                            @elseif($data->is_paraf1==1)
                                <span class="badge badge-success mt-3">Sudah diparaf<br>{{date_format(date_create($data->paraf1_date), 'l, d F Y H:i')}}</span>
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
                <div class="col-6 pemaraf2{{($data->pemaraf2)==''? ' d-none' :'' }}">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center float-none text-center">Pemaraf<br>{{$data->pemaraf2->jabatan}}</h3>
                        </div>
                        <div class="card-body text-center" style="height: 100px;">
                            @if (auth()->id()==$data->pemaraf2->id && (int)$data->is_paraf2==0)
                                <a href="#" class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setParaf2({{$data->id}});">Paraf,<br>Klik disini</a>
                            @elseif($data->is_paraf2==1)
                                <span class="badge badge-success mt-3">Sudah diparaf<br>{{date_format(date_create($data->paraf2_date), 'l, d F Y H:i')}}</span>
                            @else
                                <span class="badge badge-danger mt-3">Belum diparaf</span>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{$data->pemaraf2->name}}
                            <br>
                            {{$data->pemaraf2->nip}}
                        </div>
                    </div>
                </div>
                <div class="col-6 pettd{{($data->pemaraf2)==''? '' :' offset-3' }}">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center float-none text-center">Penandatangan<br>{{$data->pettd->jabatan}}</h3>
                        </div>
                        <div class="card-body text-center" style="height: 100px;" id="container-btn-ttd">
                            @if(auth()->id()==$data->pettd->id && (int)$data->is_ttd==0)
                                <a href="#" class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setTtd({{$data->id}});">Tandatangan,<br>Klik disini</a>
                            @elseif($data->is_ttd==1)
                                <span class="badge badge-success mt-3">Sudah ditandatangan<br>{{date_format(date_create($data->ttd_date), 'l, d F Y H:i')}}</span>
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
        </div>
    </div>
@endsection

@push('js')
<script>
const url_id = "<?php echo $data->link_surat  ?>"

</script>
    <script src="/assets/app/surat-keluar/detail-surat.js"></script>
@endpush