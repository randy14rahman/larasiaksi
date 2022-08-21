<?php
// use Zend\Debug\Debug;
// Debug::dump($data);die;
?>
@extends('adminlte::page')

@section('title_prefix', 'Dashboard -')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
<div class="row d-none">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p class="mb-0">You are logged in!</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Surat Masuk</h3>
                </div>
            </div>
            <div class="card-body">
                <div id="pie-sm" style="height: 220px;"></div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-4">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{$data['surat_masuk']['stats']->surat_baru??0}}</h5>
                            <span class="description-text">Surat Baru</span>
                        </div>

                    </div>

                    <div class="col-4">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{$data['surat_masuk']['stats']->disposisi??0}}</h5>
                            <span class="description-text">Disposisi</span>
                        </div>

                    </div>

                    <div class="col-4">
                        <div class="description-block">
                            <h5 class="description-header">{{$data['surat_masuk']['stats']->proses??0}}</h5>
                            <span class="description-text">Proses</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Surat Keluar</h3>
                </div>
            </div>
            <div class="card-body">
                <div id="pie-sk" style="height: 220px;"></div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-primary"></span>
                            <h5 class="description-header">{{$data['surat_keluar']['stats']->draft??0}}</h5>
                            <span class="description-text">Draft Surat</span>
                        </div>

                    </div>

                    <div class="col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-warning"></span>
                            <h5 class="description-header">{{$data['surat_keluar']['stats']->paraf??0}}</h5>
                            <span class="description-text">Paraf</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <div id="bar-jumlah-smsk-pbln" style="height: 255px;"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Statistik Surat</h3>
                </div>
            </div>
            <div class="card-body" style="height: 250px;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-envelope"></i><span class="ml-2">Arsip Surat Keluar</span>
                            <span class="badge bg-success float-right">{{$data['surat_keluar']['stats']->arsip??0}}</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <i class="fas fa-inbox"></i><span class="ml-2">Arsip Surat Masuk</span>
                            <span class="badge bg-success float-right">{{$data['surat_masuk']['stats']->arsip??0}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-file-alt"></i><span class="ml-2">Disposisi Selesai</span>
                            <span class="badge bg-primary float-right">{{$data['surat_masuk']['stats']->disposisi??0}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-filter"></i><span class="ml-2">Disposisi Proses</span>
                            <span class="badge bg-info float-right">{{$data['surat_masuk']['stats']->disposisi??0}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-trash-alt"></i><span class="ml-2">Disposisi Proses > 7 hari</span>
                            <span class="badge bg-danger float-right">{{$data['surat_masuk']['stats']->arsip??0}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop



@push('js')
    <script type="text/javascript" src="/assets/plugins/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="/assets/plugins/highcharts/modules/no-data-to-display.js?.js"></script>
    <script>const data = <?= json_encode($data) ?>; console.log(data.surat_keluar.trendline)</script>
    <script src="/assets/app/home.js"></script>
@endpush