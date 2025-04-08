@extends('layouts.admin')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><b>Detalle Retiro #{{ $retiros->id }} Cliente {{ $retiros->cliente->apellidos }}
                {{ $retiros->cliente->nombres }}</b>
        </h1>
        <div class="form-group">
            <a href="{{ url('/admin/retiros') }}" class="btn btn-danger">Volver</a>
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informacion del Retiro</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha de Pago</label>
                                <p><i class="fas fa-id-card"></i> {{ $retiros->fecha_retiro }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Total Pago</label>
                                <p><i class="fas fa-dollar-sign"></i> {{ $retiros->total_retiro }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Forma de Pago</label>
                                <p><i class="fas fa-credit-card"></i> {{ $retiros->metodo_retiro }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Detalle de Pago</label>
                                <p><i class="fas fa-info-circle"></i> {{ $retiros->detalle_retiro }}</p>
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
