@extends('layouts.admin')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><b>Detalle Pago Interes Cliente {{ $cliente->apellidos }} {{ $cliente->nombres }}</b></h1>
        <div class="form-group">
            <a href="{{ url('/admin/cuotas') }}" class="btn btn-danger">Volver</a>
        </div>
    </div>

@stop

@section('content')
    <form action="{{ url('admin/cuotas/interes') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informacion del Cliente</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                <input type="text" value="{{ $cliente->id }}" id="cliente_id" name="cliente_id"
                                    class="form-control" placeholder="Escriba aquí..." hidden>
                            </button>

                        </div>
                    </div>
                    <div class="card-body collapse show">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-id-card"></i> Nro de Identificación:</label>
                                    <span id="nro_documento">{{ $cliente->nro_documento }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-user"></i> Apellidos:</label>
                                    <span id="apellidos">{{ $cliente->apellidos }} {{ $cliente->nombres }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt"></i> Fecha de Afiliación:</label>
                                    <span name="fecha_afiliacion" id="fecha_afiliacion"
                                        name="fecha_afiliacion">{{ $cliente->fecha_afiliacion }}</span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-envelope"></i> Saldo Actual:</label>
                                    <span id="email">{{ $cliente->saldo_ahorro }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-mobile-alt"></i> Nro Acciones:</label>
                                    <span id="celular">{{ $cliente->acciones }}</span>
                                </div>
                            </div>


                        </div>
                    </div>

                </div> <!-- /.card-body -->
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Informacion del interes</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body collapse show">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-id-card"></i> Saldo Anterior:</label>
                                    <span id="saldo_ahorro">{{ $cliente->saldo_ahorro1 }}</span>
                                    <input type="text" value="{{ $cliente->saldo_ahorro1 }}" id="saldo_ahorro1"
                                        name="saldo_ahorro1" class="form-control" placeholder="Escriba aquí..." hidden>
                                    <input type="text" value="{{ $cliente->saldo_ahorro }}" id="saldo_ahorro"
                                        name="saldo_ahorro" class="form-control" placeholder="Escriba aquí..." hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-user"></i> Ahorro Anual:</label>
                                    <span id="ahorro_anual">{{ $cliente->saldo_ahorro - $cliente->saldo_ahorro1 }}</span>
                                    <input type="text" value="{{ $cliente->saldo_ahorro - $cliente->saldo_ahorro1 }}"
                                        id="ahorro_anual" name="ahorro_anual" class="form-control"
                                        placeholder="Escriba aquí..." hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt"></i> Tasa Interes Anual:</label>
                                    <span id="ahorro_anual">10 %</span>
                                    <input type="text" value=0,10 id="tasa_interes_anual" name="tasa_interes_anual"
                                        class="form-control" placeholder="Escriba aquí..." hidden>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-envelope"></i> Interes Generado:</label>
                                    <span id="interes_generado">{{ $cliente->saldo_ahorro * 0.1 }}</span>
                                    <input type="text" value="{{ $cliente->saldo_ahorro * 0.1 }}"
                                        id="interes_generado" name="interes_generado" class="form-control"
                                        placeholder="Escriba aquí..." hidden>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <button type="submit" name="action" value="pagar" class="btn btn-success">Pagar
                                    Interes</button>


                            </div>

                        </div>

                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->


            </div>
        </div>
    </form>
@stop


@section('css')
@stop

@section('js')
@stop
