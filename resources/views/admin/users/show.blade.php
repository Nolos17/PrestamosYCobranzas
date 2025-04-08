@extends('layouts.admin')

@section('content_header')
<h1><b>Usuarios Registrados</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Información del Usuario</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="display: inline;"><i class="fas fa-user-tag mr-2"></i> Rol del Usuario:</label>
                                    <span style="margin-left: 5px;">{{$user->roles->pluck('name')->implode(', ')}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="display: inline;"><i class="fas fa-user mr-2"></i> Nombre:</label>
                                    <span style="margin-left: 5px;">{{$user->name}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="display: inline;"><i class="fas fa-envelope mr-2"></i> Email:</label>
                                    <span style="margin-left: 5px;">{{$user->email}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <a href="{{ url('/admin/users') }}" class="btn btn-danger">Volver</a>
                        </div>
                    </div>
                </div>
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div>
</div>
@stop

@section('css')
<style>
    .form-group span {
        color: #333;
        font-size: 1rem;
    }
</style>
@stop

@section('js')
@stop