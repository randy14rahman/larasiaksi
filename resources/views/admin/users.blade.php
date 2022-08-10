@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1 class="m-0 text-dark">User Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">User list</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-user">Add
                                user</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable-1" class="table table-striped table-bordered" style="width:100%"></table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New user</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-add-user" novalidate="novalidate"  name="form-add">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip" class="form-control" placeholder="NIP">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Atribut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_pemaraf" value="1">
                                <label class="form-check-label">Pemaraf</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_pettd" value="1">
                                <label class="form-check-label">Penandatangan</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="">Role</label>
                            <select class="form-control list-role" name="role">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary btn-submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit user</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit-user" novalidate="novalidate" name="form-edit">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip" class="form-control" id="nip" placeholder="NIP" min="18" max="18">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Jabatan">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Atribut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_pemaraf" name="is_pemaraf" value="1">
                                <label class="form-check-label">Pemaraf</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_pettd" name="is_pettd" value="1">
                                <label class="form-check-label">Penandatangan</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="">Role</label>
                            <select class="form-control list-role" name="role" id="role">
                            </select>
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
<script src="/assets//plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets//plugins/jquery-validation/additional-methods.min.js"></script>
<script src="/assets/app/users/index.js"></script>
@endpush