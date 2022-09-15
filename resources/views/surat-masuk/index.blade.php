@php
use Zend\Debug\Debug;
@endphp

@extends('adminlte::page')
@section('title', 'Surat Masuk')

@push('css')
<style>
.error.invalid-feedback {
    display: none !important;
}
</style>
@endpush

@section('content_header')
<h1 class="m-0 text-dark">Surat Masuk</h1>
@stop

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
            <form id="form-surat-masuk" enctype="multipart/form-data" novalidate="novalidate">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="col-form-label col-4">Tanggal Surat <span
                                        class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="date" class="form-control" name="tanggal_surat"
                                        value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-4">Asal Surat <span
                                        class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input name="asal_surat" type="text" class="form-control" id="asal_surat"
                                        placeholder="Masukan Asal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-4">Perihal <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input name="perihal_surat" type="text" class="form-control" id="perihal_surat"
                                        placeholder="Masukan Perihal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-4">Nomor Surat <span
                                        class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input name="nomor_surat" type="text" class="form-control" id="nomor_surat"
                                        placeholder="Masukan Nomor">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1">
                            <div class="form-group row">
                                <label class="col-form-label col-4">Jenis Surat <span
                                        class="text-danger">*</span></label>
                                <div class="col-8">
                                    <select name="jenis_surat_masuk" class="form-control form-select"
                                        aria-label="Default select example" id="jenis_surat_masuk">
                                        <option value="1">Penting</option>
                                        <option value="0">Biasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-4">Upload File <span
                                        class="text-danger">*</span></label>
                                <div class="col-8">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="formFile" name="file"
                                            accept="application/pdf">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-form-label col-4">Disampaikan ke <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <select name="ditugaskan_ke" class="form-control form-select"
                                        aria-label="Default select example" id="ditugaskan_ke">
                                        <option value="">Pilih penerima</option>
                                        @foreach($users_penugasan as $v)
                                        <option value="{{$v->id}}">{{$v->nip}} | {{$v->name}} | {{$v->jabatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-submit-surat-masuk float-right">Submit</button>
                </div>
            </form>
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
                <table id="datatable-surat" class="table" style="width:100"></table>
            </div>
        </div>
    </div>
</div>
<div class="row mt-5 d-none">
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
<script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
const user_id = {
    {
        $id_user
    }
}
</script>
<script src="/assets/app/surat-masuk/index.js"></script>
@endpush