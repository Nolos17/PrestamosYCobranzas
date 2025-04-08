@extends('layouts.admin')

@section('content_header')
<h1><b>Registro de Pagos</b></h1>
@endsection

@section('content')
<form action="{{ url('admin/cuotas/create') }}" method="post" enctype="multipart/form-data">
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
                                        @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nro_documento . " - " . $cliente->apellidos . " " . $cliente->nombres }}</option>
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

            <!-- Sección de Pagos -->
            <div id="seccion-pagos" class="card card-warning" style="display: none;">
                <div class="card-header">
                    <h3 class="card-title">Agregar Pagos</h3>
                </div>
                <div class="card-body">
                    <!-- Botones de Acción -->
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-success" id="pagoPrestamoMesActual">Cargar Pago Préstamo Mes Actual</button>
                            <button type="button" class="btn btn-success" id="pagoAhorroMesActual">Cargar Pago Ahorro Mes Actual</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPrecancelarPrestamo" id="precancelarPrestamo">Precancelar Préstamo</button>
                        </div>
                    </div>
                    <hr>
                    <!-- Tabla de Cuotas Seleccionadas -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Cuotas a Pagar</h5>
                            <table class="table table-bordered" id="cuotasSeleccionadasTable">
                                <thead>
                                    <tr>
                                        <th>Transacción</th>
                                        <th>Detalle</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Monto</th>
                                        <th>Multa</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="cuotasSeleccionadasBody">
                                    <!-- Las cuotas seleccionadas se agregarán aquí -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><b>Método de Pago:</b></td>
                                        <td colspan="2">
                                            <select name="metodo_pago" id="metodo_pago" class="form-control">
                                                <option value="efectivo">Efectivo</option>
                                                <option value="tarjeta">Tarjeta</option>
                                                <option value="transferencia">Transferencia</option>
                                            </select>
                                        </td>
                                        <td><b>Total a Pagar:</b></td>
                                        <td id="totalMonto">0</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Fecha de Pago:</b></td>
                                        <td colspan="5">
                                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Detalle del Pago:</b></td>
                                        <td colspan="5">
                                            <input type="text" name="detalle_pago" id="detalle_pago" class="form-control" placeholder="Ingrese detalles del pago">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="{{ url('/admin/cuotas') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>

    <!-- Campos ocultos para almacenar los datos -->
    <input type="hidden" name="pagos_seleccionados" id="pagos_seleccionados">
    <input type="hidden" name="montos_pagos" id="montos_pagos">
    <input type="hidden" name="multas_pagos" id="multas_pagos">
    <input type="hidden" name="total_monto" id="total_monto">

    <!-- Modal para Precancelar Préstamo -->
    <div class="modal fade" id="modalPrecancelarPrestamo" tabindex="-1" role="dialog" aria-labelledby="modalPrecancelarPrestamoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPrecancelarPrestamoLabel">
                        <i class="fas fa-list-alt mr-2"></i>Precancelar Préstamo
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>ID Préstamo</th>
                                    <th>Detalle</th>
                                    <th>Monto</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Multa</th>
                                </tr>
                            </thead>
                            <tbody id="cuotasPrecancelarBody">
                                <!-- Cuotas pendientes para precancelar se cargarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" id="agregarCuotasPrecancelar">
                        <i class="fas fa-check mr-1"></i> Agregar Cuotas Seleccionadas
                    </button>
                </div>
            </div>
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

        // Almacenar las cuotas seleccionadas
        let cuotasSeleccionadas = [];
        let multaConfig = 0; // Variable para almacenar la multa de la configuración

        // Obtener la multa desde la tabla de configuraciones
        $.ajax({
            url: "{{ url('/admin/configuraciones/multa') }}",
            type: 'GET',
            success: function(config) {
                multaConfig = parseFloat(config.multa) || 0;
                console.log('Multa configurada:', multaConfig);
            },
            error: function(xhr) {
                console.log('Error al obtener la multa:', xhr.responseText);
                alert("No se pudo obtener la multa de la configuración");
            }
        });

        // Cargar datos del cliente y cuotas/ahorros al seleccionar un cliente
        $('#cliente_id').on('change', function() {
            var clienteId = $(this).val();
            if (clienteId) {
                // Obtener datos del cliente
                $.ajax({
                    url: "{{ url('/admin/cuotas/cliente') }}/" + clienteId,
                    type: 'GET',
                    success: function(cliente) {
                        $("#contenido-cliente").css('display', 'block');
                        $("#seccion-pagos").css('display', 'block');
                        $("#nro_documento").text(cliente.nro_documento);
                        $("#apellidos").text(cliente.apellidos + ' ' + cliente.nombres);
                        $("#celular").text(cliente.celular);
                        $("#fecha_afiliacion").text(cliente.fecha_afiliacion);
                        $("#acciones").text(cliente.acciones);
                        $("#saldo_ahorro").text(cliente.saldo_ahorro);

                        // Cargar cuota del mes actual
                        $.ajax({
                            url: "{{ url('/admin/cuotas/pagos-pendientes') }}/" + clienteId,
                            type: 'GET',
                            success: function(pagos) {
                                console.log('Datos de pagos (préstamos) recibidos:', pagos);
                                window.cuotaMesActual = null;
                                const fechaActual = new Date();
                                const mesActual = fechaActual.getMonth() + 1; // Mes actual (1-12)
                                const anioActual = fechaActual.getFullYear();

                                // Filtrar la cuota del mes actual
                                pagos.forEach(function(pago) {
                                    const fechaVencimiento = new Date(pago.fecha_vencimiento);
                                    const mesVencimiento = fechaVencimiento.getMonth() + 1;
                                    const anioVencimiento = fechaVencimiento.getFullYear();

                                    if (mesVencimiento === mesActual && anioVencimiento === anioActual) {
                                        window.cuotaMesActual = pago;
                                    }
                                });

                                // Cargar todas las cuotas pendientes para el modal de precancelar
                                var cuotasPrecancelarBody = $('#cuotasPrecancelarBody');
                                cuotasPrecancelarBody.empty();
                                if (pagos.length === 0) {
                                    cuotasPrecancelarBody.append('<tr><td colspan="6">No hay cuotas pendientes para precancelar.</td></tr>');
                                } else {
                                    pagos.forEach(function(pago) {
                                        const fechaVencimiento = new Date(pago.fecha_vencimiento);
                                        const fechaActual = new Date();
                                        const multa = fechaVencimiento < fechaActual ? multaConfig : 0;

                                        cuotasPrecancelarBody.append(
                                            '<tr>' +
                                            '<td><input type="checkbox" class="pago-checkbox" value="' + pago.id + '" data-pago=\'' + JSON.stringify(pago).replace(/'/g, "\\'") + '\'></td>' +
                                            '<td>' + (pago.prestamo_id || 'N/A') + '</td>' +
                                            '<td>' + (pago.detalle || 'Sin detalle') + '</td>' +
                                            '<td>' + (pago.monto || '0') + '</td>' +
                                            '<td>' + (pago.fecha_vencimiento || 'N/A') + '</td>' +
                                            '<td>' + multa.toFixed(2) + '</td>' +
                                            '</tr>'
                                        );
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.log('Error al obtener pagos de préstamos:', xhr.responseText);
                                alert("No se pudo obtener los pagos pendientes del cliente");
                            }
                        });

                        // Cargar ahorro del mes actual
                        $.ajax({
                            url: "{{ url('/admin/cuotas/ahorros-pendientes') }}/" + clienteId,
                            type: 'GET',
                            success: function(ahorros) {
                                console.log('Datos de ahorros recibidos:', ahorros);
                                window.ahorroMesActual = null;
                                const fechaActual = new Date();
                                const mesActual = fechaActual.getMonth() + 1;
                                const anioActual = fechaActual.getFullYear();

                                // Filtrar el ahorro del mes actual
                                ahorros.forEach(function(ahorro) {
                                    const fechaVencimiento = ahorro.fecha_vencimiento ? new Date(ahorro.fecha_vencimiento) : null;
                                    if (fechaVencimiento) {
                                        const mesVencimiento = fechaVencimiento.getMonth() + 1;
                                        const anioVencimiento = fechaVencimiento.getFullYear();

                                        if (mesVencimiento === mesActual && anioVencimiento === anioActual) {
                                            window.ahorroMesActual = ahorro;
                                        }
                                    }
                                });
                            },
                            error: function(xhr) {
                                console.log('Error al obtener ahorros:', xhr.responseText);
                                alert("No se pudo obtener los ahorros pendientes del cliente");
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log('Error al obtener datos del cliente:', xhr.responseText);
                        alert("No se pudo obtener la información del cliente");
                        $("#contenido-cliente").css('display', 'none');
                        $("#seccion-pagos").css('display', 'none');
                    }
                });
            } else {
                $("#contenido-cliente").css('display', 'none');
                $("#seccion-pagos").css('display', 'none');
                cuotasSeleccionadas = [];
                actualizarTablaCuotasSeleccionadas();
            }
        });

        // Cargar Pago de Préstamo del Mes Actual
        $('#pagoPrestamoMesActual').on('click', function() {
            if (window.cuotaMesActual) {
                const fechaVencimiento = new Date(window.cuotaMesActual.fecha_vencimiento);
                const fechaActual = new Date();
                const multa = fechaVencimiento < fechaActual ? multaConfig : 0;
                const total = parseFloat(window.cuotaMesActual.monto) + multa;

                cuotasSeleccionadas = [{
                    id: window.cuotaMesActual.id,
                    transaccion: window.cuotaMesActual.transaccion,
                    detalle: window.cuotaMesActual.detalle,
                    fecha_vencimiento: window.cuotaMesActual.fecha_vencimiento,
                    monto: window.cuotaMesActual.monto,
                    multa: multa,
                    total: total
                }];
                actualizarTablaCuotasSeleccionadas();
            } else {
                alert("No hay cuota de préstamo pendiente para el mes actual.");
            }
        });

        // Cargar Pago de Ahorro del Mes Actual
        $('#pagoAhorroMesActual').on('click', function() {
            if (window.ahorroMesActual) {
                const fechaVencimiento = window.ahorroMesActual.fecha_vencimiento ? new Date(window.ahorroMesActual.fecha_vencimiento) : null;
                const fechaActual = new Date();
                const multa = fechaVencimiento && fechaVencimiento < fechaActual ? multaConfig : 0;
                const total = parseFloat(window.ahorroMesActual.monto) + multa;

                cuotasSeleccionadas = [{
                    id: window.ahorroMesActual.id,
                    transaccion: window.ahorroMesActual.transaccion,
                    detalle: window.ahorroMesActual.detalle,
                    fecha_vencimiento: window.ahorroMesActual.fecha_vencimiento || 'N/A',
                    monto: window.ahorroMesActual.monto,
                    multa: multa,
                    total: total
                }];
                actualizarTablaCuotasSeleccionadas();
            } else {
                alert("No hay ahorro pendiente para el mes actual.");
            }
        });

        // Manejar la selección de cuotas para precancelar
        $('#agregarCuotasPrecancelar').on('click', function() {
            console.log('Agregando cuotas para precancelar...');
            cuotasSeleccionadas = [];
            $('.pago-checkbox:checked').each(function() {
                var pagoData = $(this).data('pago');
                console.log('Cuota seleccionada:', pagoData);
                if (pagoData) {
                    const fechaVencimiento = new Date(pagoData.fecha_vencimiento);
                    const fechaActual = new Date();
                    const multa = fechaVencimiento < fechaActual ? multaConfig : 0;
                    const total = parseFloat(pagoData.monto) + multa;

                    cuotasSeleccionadas.push({
                        id: pagoData.id,
                        transaccion: pagoData.transaccion,
                        detalle: pagoData.detalle,
                        fecha_vencimiento: pagoData.fecha_vencimiento,
                        monto: pagoData.monto,
                        multa: multa,
                        total: total
                    });
                }
            });
            actualizarTablaCuotasSeleccionadas();
            $('#modalPrecancelarPrestamo').modal('hide');
        });

        // Manejar la eliminación de una cuota de la tabla
        $(document).on('click', '.eliminar-cuota', function() {
            var index = $(this).data('index');
            cuotasSeleccionadas.splice(index, 1);
            actualizarTablaCuotasSeleccionadas();
        });

        // Función para actualizar la tabla de cuotas seleccionadas
        function actualizarTablaCuotasSeleccionadas() {
            var cuotasSeleccionadasBody = $('#cuotasSeleccionadasBody');
            cuotasSeleccionadasBody.empty();

            if (cuotasSeleccionadas.length === 0) {
                cuotasSeleccionadasBody.append('<tr><td colspan="7">No hay cuotas seleccionadas.</td></tr>');
            } else {
                cuotasSeleccionadas.forEach(function(item, index) {
                    cuotasSeleccionadasBody.append(
                        '<tr>' +
                        '<td>' + (item.transaccion || 'Desconocido') + '</td>' +
                        '<td>' + (item.detalle || 'Sin detalle') + '</td>' +
                        '<td>' + (item.fecha_vencimiento || 'N/A') + '</td>' +
                        '<td>' + parseFloat(item.monto).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(item.multa).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(item.total).toFixed(2) + '</td>' +
                        '<td><button type="button" class="btn btn-danger btn-sm eliminar-cuota" data-index="' + index + '">Eliminar</button></td>' +
                        '</tr>'
                    );
                });
            }

            // Actualizar campos ocultos
            var pagosSeleccionados = cuotasSeleccionadas.map(item => item.id);
            $('#pagos_seleccionados').val(pagosSeleccionados.join(','));

            var montosPagos = cuotasSeleccionadas.map(item => item.monto);
            $('#montos_pagos').val(montosPagos.join(','));

            var multasPagos = cuotasSeleccionadas.map(item => item.multa);
            $('#multas_pagos').val(multasPagos.join(','));

            var totalMonto = cuotasSeleccionadas.reduce((sum, item) => sum + parseFloat(item.total), 0);
            $('#totalMonto').text(totalMonto.toFixed(2));
            $('#total_monto').val(totalMonto.toFixed(2));
        }
    });
</script>
@endsection