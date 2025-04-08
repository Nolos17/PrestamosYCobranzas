@extends('layouts.admin')

@section('content_header')
<h1><b>Modificacion de Usuario</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">

                <form action="{{url ('admin/clientes',$cliente->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method ('put')
                    <div class=row>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nro de identificacion</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text" name="nro_documento" value="{{$cliente->nro_documento}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nro_documento')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Apellidos</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="apellidos" value="{{$cliente->apellidos}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('apellidos')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombres</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="nombres" value="{{$cliente->nombres}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombres')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fecha de Nacimiento</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" name="fecha_nacimiento" value="{{$cliente->fecha_nacimiento}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('fecha_nacimiento')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="genero">Seleccione el Género</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div>
                                            <select name="genero" id="genero" class="form-control">
                                                <option value="" disabled>Seleccione una opción</option>
                                                <option value="masculino" {{ $cliente->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ $cliente->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                                <option value="otro" {{ $cliente->genero == 'otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                        </div>
                                        @error('genero')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Correo Electronico</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" value="{{$cliente->email}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('email')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            </div>
                                            <input type="text" name="celular" value="{{$cliente->celular}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('celular')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Ref. Celular</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="ref_celular" value="{{$cliente->ref_celular}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('ref_celular')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Nro. Acciones</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                            </div>
                                            <input type="number" name="acciones" value="{{$cliente->acciones}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fecha de Afiliacion</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                            </div>
                                            <input type="date" name="fecha_afiliacion" value="{{$cliente->fecha_afiliacion}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Saldo Actual(No modificable)</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                            </div>
                                            <input type="text" name="saldo_ahorro2" value="{{$cliente->saldo_ahorro}}" class="form-control" placeholder="Escriba aquí..." disabled required>
                                            <input type="text" name="saldo_ahorro1" value="{{$cliente->saldo_ahorro}}" class="form-control" placeholder="Escriba aquí..." hidden>
                                            <input type="text" name="saldo_ahorro" value="{{$cliente->saldo_ahorro}}" class="form-control" placeholder="Escriba aquí..." hidden>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="md-col-6">
                            <div class="form-group">
                                <a href="{{ url('/admin/clientes') }}" class="btn btn-danger">Cancelar</a>
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