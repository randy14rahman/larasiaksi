@extends('adminlte::page')
@section('title_prefix', 'Arsip -')

@push('css')
<style>
    table.dataTable tbody td.valign-middle {
    vertical-align: middle;
    }
</style>
@endpush

@section('content_header')
    <h1 class="m-0 text-dark">Arsip</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <h4> Daftar Arsip Surat Masuk</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatable-arsip-surat-masuk" class="table table-stripped" style="width:100%" style="width:100%"></table>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <h4> Daftar Arsip Surat Keluar</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatable-arsip-surat-keluar" class="table table-stripped" style="width:100%" style="width:100%"></table>
        </div>
    </div>

    <div class="modal fade" id="modal-detail-surat">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <div id="show-pdf"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js"></script>
    <script>const user_id = <?= auth()->id() ?>;</script>
    <script src="/assets/app/arsip/surat-masuk.js"></script>
    <script src="/assets/app/arsip/index.js"></script>
@endpush