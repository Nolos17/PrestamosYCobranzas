@extends('layouts.admin')

@section('content_header')
<h1><b>Roles/Agregar permisos {{ $rol->name }}</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/roles/asignar/' . $rol->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($permisos as $modulo => $grupoPermisos)
                                <div class="col-md-4">
                                    <h3>{{ $modulo }}</h3>
                                    @foreach($grupoPermisos as $permiso)
                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input"
                                            name="permisos[]"
                                            value="{{ $permiso->id }}"
                                            @checked($rol->hasPermissionTo($permiso->name))>
                                        <label class="form-check-label">{{ $permiso->name }}</label>
                                    </div>
                                    @endforeach
                                    <br>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="{{ url('/admin/roles') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Registrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop