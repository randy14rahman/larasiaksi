@extends('adminlte::page')
@section('title_prefix', 'Surat Keluar -')

@push('css')
    <style>
        .error.invalid-feedback {
            display: none !important;
        }
    </style>
@endpush

@section('content_header')
    <h1 class="m-0 text-dark">Surat Keluar</h1>
@stop

@section('content')
@if(auth()->user()->role_id==2)
    <div class="card mb-5">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <h4> Buat Surat</h4>
                </div>
            </div>
        </div>
        <form id="form-add-surat-keluar" enctype="multipart/form-data" novalidate="novalidate">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group row">
                            <label class="col-form-label col-4">Tanggal Surat <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="date" class="form-control" name="tanggal_surat" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">Perihal <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="perihal" placeholder="Masukan Perihal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">Nomor Surat <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="nomor_surat" placeholder="Masukan Nomor Surat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">Judul Surat <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="judul_surat" placeholder="Masukan Judul Surat">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 offset-1">
                        <div class="form-group row">
                            <label class="col-form-label col-4">Penandatangan <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select class="form-control" id="pettd" name="pettd">
                                    <option value="">Pilih Penandatangan</option>
                                    @foreach ($users_pettd as $k => $v)
                                        <option value="{{$v->id}}" data-level="{{$v->level}}">{{$v->nip}} | {{$v->name}} | {{$v->jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">Pemaraf 1 <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select class="form-control pemaraf" id="pemaraf1" name="pemaraf1">
                                    <option value="">Pilih Pemaraf</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">
                                Pemaraf 2 <small>(optional)</small>
                            </label>
                            <div class="col-8">
                                <select class="form-control pemaraf" id="pemaraf1" name="pemaraf2">
                                    <option value="">Pilih Pemaraf</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-4">Upload File <span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file" accept="application/pdf">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info float-right">Buat Surat</button>
            </div>
        </form>
    </div>
@endif
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
            <table id="datatable-surat-keluar" class="table table-stripped" style="width:100%" style="width:100%"></table>
        </div>
    </div>

    <div class="modal fade" id="modal-detail-surat">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div id="show-pdf"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                   <dt class="col-4">Perihal</dt>
                                   <dd class="col-8">: <span id="detail-perihal"></span></dd>
                                </div>
                                <div class="form-group row">
                                   <dt class="col-4">Judul Surat</dt>
                                   <dd class="col-8">: <span id="detail-judul_surat"></span></dd>
                                </div>
                                <div class="form-group row">
                                   <dt class="col-4">Tanggal Surat</dt>
                                   <dd class="col-8">: <span id="detail-tanggal_surat"></span></dd>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 pemaraf1 text-center">
                                        <strong>Pemaraf</strong>
                                        <address>
                                            <span>Name</span>
                                            <div></div>
                                            <span>NIP</span>
                                            <br>
                                            <span>Jabatan</span>
                                        </address>
                                    </div>
                                    <div class="col-6 pemaraf2 text-center">
                                        <strong>Pemaraf</strong>
                                        <address>
                                            <span>Name</span>
                                            <div></div>
                                            <span>NIP</span>
                                            <br>
                                            <span>Jabatan</span>
                                        </address>
                                    </div>
                                    <div class="col-6 offset-3 pettd text-center">
                                        <strong>Penandatangan</strong>
                                        <address>
                                            <span>Name</span>
                                            <div></div>
                                            <span>NIP</span>
                                            <br>
                                            <span>Jabatan</span>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js"></script>
    <script>const user_id = <?= auth()->id() ?>;</script>
    <script src="/assets/app/surat-keluar/index.js"></script>
@endpush