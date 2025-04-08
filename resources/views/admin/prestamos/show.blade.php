@extends('layouts.admin')
@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1><b>Detalle Prestamo</b></h1>
        </div>
        <div class="col-md-6 text-right">
            <div class="form-group">
                <a href="{{ url('/admin/prestamos') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </div>
@stop

@section('content')



    <div class="row">

        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label><i class="fas fa-user"></i> Identificacion:</label>
                                        <span id="cliente">{{ $cliente->nro_documento }} </span>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label><i class="fas fa-user"></i> Cliente:</label>
                                        <span id="cliente">{{ $cliente->apellidos }} {{ $cliente->nombres }}</span>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-calendar-alt"></i> Fecha Inicio Préstamo:</label>
                                        <span id="fecha_inicio">{{ $prestamo->fecha_inicio }}</span>
                                    </div>
                                </div>



                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-group text-center {{ $prestamo->estado == 'Activo' ? 'text-success' : 'text-danger' }}"
                                        style="font-size: 1.25rem;">
                                        <label><i class="fas fa-info-circle"></i> Estado del Préstamo:</label>
                                        <span id="estado_prestamo"><b>{{ $prestamo->estado }}</b></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-info-circle"></i> Tipo de Préstamo:</label>
                                        <span id="estado_prestamo">{{ $prestamo->metodo_prestamo }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-info-circle"></i> Tasa de Interes:</label>
                                        <span id="estado_prestamo">{{ $prestamo->tasa_interes_anual }} %</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-info-circle"></i> Modalidad Pago:</label>
                                        <span id="estado_prestamo">{{ $prestamo->modalidad }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave"></i> Monto Total solicitado:</label>
                                        <span id="monto_total">{{ $prestamo->monto_prestado }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave"></i> Monto Total a pagar:</label>
                                        <span id="monto_total">{{ $prestamo->monto_total1 }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave"></i> Nro Cuotas:</label>
                                        <span id="monto_total">{{ $prestamo->nro_cuotas }}</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                @php
                                    $cuotasPagadas = $cuotas->where('estado', 'Pagado')->count();
                                    $cuotasPendientes = $cuotas->where('estado', 'Pendiente')->count();
                                    $saldoPendienteTotal = $cuotas->where('estado', 'Pendiente')->sum('monto_cuota');
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-check-circle"></i> Cuotas Pagadas:</label>
                                        <span id="cuotas_pagadas">{{ $cuotasPagadas }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-exclamation-triangle"></i> Cuotas Pendientes:</label>
                                        <span id="cuotas_pendientes">{{ $cuotasPendientes }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave"></i> Total Pendiente:</label>
                                        <span id="saldo_pendiente">{{ $saldoPendienteTotal }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Detalle de Cuotas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body collapse show">
                            <div class=row>
                                <table id=example1 class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Nro</th>

                                            <th style="text-align: center">Referencia de Pago</th>
                                            <th style="text-align: center">Monto</th>
                                            <th style="text-align: center">Monto</th>
                                            <th style="text-align: center">Multa</th>
                                            <th style="text-align: center">Fecha de Pago</th>
                                            <th style="text-align: center">Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $contador = 1;
                                        @endphp
                                        @foreach ($cuotas as $prestamo)
                                            <tr>
                                                <td style="text-align: center">{{ $contador++ }}</td>
                                                <td>{{ $prestamo->referencia_pago }}</td>
                                                <td>{{ $prestamo->monto_cuota }}</td>
                                                <td>{{ $prestamo->multa }}</td>
                                                <td>{{ $prestamo->estado }}</td>
                                                <td>{{ $prestamo->fecha_pago }}</td>
                                                <td>{{ $prestamo->detalle_pago }}</td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
        <div class="col-md-12">

        </div> <!-- /.card -->

    </div>

@stop


@section('css')

@stop

@section('js')

@stop
