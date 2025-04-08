@extends('layouts.admin')

@section('content_header')
    <h1><b>Retiro de Ahorros</b></h1>
    <p><strong>Saldo Disponible: </strong><span id="saldoDisponible">{{ $saldo }}</span></p>
@endsection

@section('content')
    <form action="{{ url('admin/retiros/create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <!-- Sección de Datos del Cliente -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Datos del Cliente</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cliente_id">Búsqueda de Cliente</label>
                                    <div class="input-group mb-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <select name="cliente_id" id="cliente_id" class="form-control select2">
                                            <option value="">Buscar Cliente...</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}">
                                                    {{ $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Datos del cliente, ocultos hasta seleccionar uno -->
                        <div id="contenido-cliente" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-id-card"></i> Nro de Identificación:</label>
                                        <span id="nro_documento"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-user"></i> Apellidos y Nombres:</label>
                                        <span id="apellidos"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-mobile-alt"></i> Celular:</label>
                                        <span id="celular"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-calendar-alt"></i> Fecha de Afiliación:</label>
                                        <span id="fecha_afiliacion"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-chart-line"></i> Nro de Acciones:</label>
                                        <span id="acciones"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave"></i> Ahorro Disponible:</label>
                                        <span id="saldo_ahorro"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->

                <!-- Sección de Retiro de Ahorros -->
                <div id="seccion-retiro" class="card card-outline card-success" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Retiro de Ahorros</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <label><i class="fas fa-wallet" style="color: green;"></i> <b
                                            style="color: green;">Saldo Disponible:</b></label>
                                    <span id="saldo_disponible" style="color: green; font-weight: bold;"></span>
                                    <input type="hidden" id="saldo_ahorro_hidden" name="saldo_ahorro">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fas fa-dollar-sign"></i> Monto a Retirar:</label>
                                    <input type="number" id="monto_retirar" name="monto_retirar" class="form-control"
                                        placeholder="Escriba aquí..." min="0" required>

                                </div>
                                @error('monto_retirar')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-day"></i> Fecha Retiro</label>
                                    <input type="date" id="fecha_retiro" name="fecha_retiro" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fas fa-file-alt"></i> Detalle</label>
                                    <textarea id="detalle_retiro" name="detalle_retiro" class="form-control" rows="3" placeholder="Escriba aquí..."
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-success">Generar Retiro</button>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div>
        </div>
    </form>
@endsection

@section('css')
    <style>
        .select2-container .select2-selection--single {
            height: 40px !important;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2').select2();

            // Cargar datos del cliente al seleccionarlo
            $('#cliente_id').on('change', function() {
                var clienteId = $(this).val();
                if (clienteId) {
                    $.ajax({
                        url: "{{ url('/admin/retiros/cliente') }}/" + clienteId,
                        type: 'GET',
                        success: function(cliente) {
                            // Mostrar sección de datos del cliente
                            $("#contenido-cliente").css('display', 'block');
                            $("#nro_documento").text(cliente.nro_documento);
                            $("#apellidos").text(cliente.apellidos + ' ' + cliente.nombres);
                            $("#celular").text(cliente.celular);
                            $("#fecha_afiliacion").text(cliente.fecha_afiliacion);
                            $("#acciones").text(cliente.acciones);
                            $("#saldo_ahorro").text(cliente.saldo_ahorro);

                            // Mostrar sección de retiro y actualizar saldo disponible
                            $("#seccion-retiro").css('display', 'block');
                            $("#saldo_disponible").text(cliente.saldo_ahorro);
                            $("#saldo_ahorro_hidden").val(cliente.saldo_ahorro);
                            $("#monto_retirar").attr('max', cliente.saldo_ahorro);
                        },
                        error: function(xhr) {
                            console.log('Error al obtener datos del cliente:', xhr
                            .responseText);
                            alert("No se pudo obtener la información del cliente");
                            $("#contenido-cliente").css('display', 'none');
                            $("#seccion-retiro").css('display', 'none');
                        }
                    });
                } else {
                    $("#contenido-cliente").css('display', 'none');
                    $("#seccion-retiro").css('display', 'none');
                    $("#saldo_disponible").text('');
                    $("#saldo_ahorro_hidden").val('');
                    $("#monto_retirar").attr('max', '');
                }
            });
        });
    </script>
@endsection
