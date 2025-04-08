@extends('layouts.admin')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><b>Detalle Pago #{{ $pagos->id }} Cliente {{ $pagos->cliente->apellidos }} {{ $pagos->cliente->nombres }}</b>
        </h1>
        <div class="form-group">
            <a href="{{ url('/admin/cuotas') }}" class="btn btn-danger">Volver</a>
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informacion del Pago</h3>
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
                                <p><i class="fas fa-id-card"></i> {{ $pagos->fecha_pago }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Total Pago</label>
                                <p><i class="fas fa-dollar-sign"></i> {{ $pagos->total_pago }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Forma de Pago</label>
                                <p><i class="fas fa-credit-card"></i> {{ $pagos->metodo_pago }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Detalle de Pago</label>
                                <p><i class="fas fa-info-circle"></i> {{ $pagos->detalle_pago }}</p>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Desgloce de Pagos</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body collapse">
                    <div class=row>
                        <table id=example1 class="table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Nro</th>
                                    <th style="text-align: center">Tipo de Pago</th>
                                    <th style="text-align: center">ID</th>
                                    <th style="text-align: center">Valor Pagado</th>
                                    <th style="text-align: center">Multa</th>
                                    <th style="text-align: center">Detalle del Cuota</th>
                                    <th style="text-align: center">Fecha de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $contador = 1;
                                @endphp
                                @foreach ($cuotas as $pagos)
                                    <tr>
                                        <td style="text-align: center">{{ $contador++ }}</td>
                                        <td>Prestamo</td>
                                        <td>{{ $pagos->prestamo->id }}</td>
                                        <td>{{ $pagos->monto_cuota }}</td>
                                        <td>{{ $pagos->monto_cuota }}</td>
                                        <td>{{ $pagos->multa }}</td>
                                        <td>{{ $pagos->fecha_pago }}</td>



                                    </tr>
                                @endforeach
                                @foreach ($ahorros as $pagos)
                                    <tr>
                                        <td style="text-align: center">{{ $contador++ }}</td>
                                        <td>Ahorro</td>
                                        <td>S/N</td>
                                        <td>{{ $pagos->monto_ahorro }}</td>
                                        <td>{{ $pagos->multa }}</td>
                                        <td>{{ $pagos->referencia_pago }}</td>
                                        <td>{{ $pagos->fecha_pago }}</td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
