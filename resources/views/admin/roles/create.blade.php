@extends('layouts.admin')

@section('content_header')
<h1><b>Agregar un Rol</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">

                <form action="{{url ('admin/roles/create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class=row>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nombre del Rol</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="text" name="name" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="md-col-6">
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