@extends('layouts.admin')

@section('content_header')
<h1><b>Registro de Usuario</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">

                <form action="{{url ('admin/users/create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class=row>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Seleccione el Rol</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <select name="rol" id="" class="form-control">
                                                @foreach($roles as $role)
                                                <option value="{{$role->name}}">
                                                    {{$role->name}}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('rol')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre del Usuario</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="text" name="name" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('name')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Correo del Usuario</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('email')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Contraseña</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('password')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Repetir Contraseña</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('password_confirmation')
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