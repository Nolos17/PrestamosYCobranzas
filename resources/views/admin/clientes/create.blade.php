@extends('layouts.admin')

@section('content_header')
<h1><b>Registro de Socio </b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">

                <form action="{{url ('admin/clientes/create')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                                            <input type="text" name="nro_documento" class="form-control" placeholder="Escriba aquí..." required>
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
                                            <input type="text" name="apellidos" class="form-control" placeholder="Escriba aquí..." required>
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
                                            <input type="text" name="nombres" class="form-control" placeholder="Escriba aquí..." required>
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
                                            <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Escriba aquí..." required>
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
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino">Femenino</option>
                                                <option value="otro">Otro</option>
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
                                            <input type="email" name="email" class="form-control" placeholder="Escriba aquí..." required>
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
                                            <input type="text" name="celular" class="form-control" placeholder="Escriba aquí..." required>
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
                                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            </div>
                                            <input type="text" name="ref_celular" class="form-control" placeholder="Escriba aquí..." required>
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
                                            <input type="number" name="acciones" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('acciones')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fecha de Afiliacion</label> <b>(*)</b>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" name="fecha_afiliacion" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('fecha_afiliacion')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Saldo Inicial(temporal)</label>
                                        <div class="input-group mb-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                            </div>
                                            <input type="number" name="saldo_ahorro" class="form-control" placeholder="Escriba aquí..." required>
                                            <input type="number" name="saldo_ahorro1" class="form-control" placeholder="Escriba aquí..." hidden>
                                        </div>
                                        @error('saldo_ahorro')
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