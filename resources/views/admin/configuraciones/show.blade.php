@extends('layouts.admin')

@section('content_header')
    <h1><b>Datos Registrados</b></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos Registrados</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-building mr-2"></i> Nombre de la institución:</label>
                                        <span>{{ $configuraciones->nombre }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-align-left mr-2"></i> Descripción de la institución:</label>
                                        <span>{{ $configuraciones->descripcion }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-map-marker-alt mr-2"></i> Dirección:</label>
                                        <span>{{ $configuraciones->direccion }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-phone mr-2"></i> Teléfono:</label>
                                        <span>{{ $configuraciones->telefono }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-envelope mr-2"></i> Email:</label>
                                        <span>{{ $configuraciones->email }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-globe mr-2"></i> Página Web:</label>
                                        <span>{{ $configuraciones->web ?? 'No especificado' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-coins mr-2"></i> Moneda:</label>
                                        <span>{{ $configuraciones->moneda }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-percentage mr-2"></i> Valor Interes Base Mensual:</label>
                                        <span>{{ $configuraciones->base_prestamo }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-dollar-sign mr-2"></i> Valor Acción:</label>
                                        <span>{{ $configuraciones->valor_accion }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-file-invoice-dollar mr-2"></i> Valor Retención:</label>
                                        <span>{{ $configuraciones->valor_retencion }}%</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-exclamation-circle mr-2"></i> Valor Multa por Mora:</label>
                                        <span>${{ $configuraciones->valor_mora }} {{ $configuraciones->moneda }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Logo:</label><br>
                                <img src="{{ asset('storage/' . $configuraciones->logo) }}" width="150px" alt="LOGO">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="{{ url('/admin/configuraciones') }}" class="btn btn-danger">Volver</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
@stop
