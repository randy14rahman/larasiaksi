@extends('adminlte::page')

@section('title', 'Role Management')

@section('content_header')
<h1 class="m-0 text-dark">Role Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Role list</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-role">Add
                            role</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-1" class="table table-striped table-bordered" style="width:100%"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add-role" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <input type="number" id="level" name="level" class="form-control" placeholder="Level">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-role" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <input type="number" id="level" name="level" class="form-control" placeholder="Level">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop

@push('js')
<script src="/assets/app/roles/index.js"></script>
@endpush