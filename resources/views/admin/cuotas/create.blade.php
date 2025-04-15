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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-hand-holding-usd"></i> Préstamos Activos:</label>
                                    <span id="prestamos_activos"></span>
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
                            <button type="button" class="btn btn-success" id="pagoPrestamoMesActual">Cargar Pago
                                Préstamo Mes Actual</button>
                            <button type="button" class="btn btn-success" id="pagoAhorroMesActual">Cargar Pago Ahorro
                                Mes Actual</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalSeleccionarPrestamo" id="precancelarPrestamo">Precancelar
                                Préstamo</button>
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
                                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Detalle del Pago:</b></td>
                                        <td colspan="5">
                                            <input type="text" name="detalle_pago" id="detalle_pago " required
                                                class="form-control" placeholder="Ingrese detalles del pago">
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

    <!-- Modal para Seleccionar Préstamo -->
    <div class="modal fade" id="modalSeleccionarPrestamo" tabindex="-1" role="dialog"
        aria-labelledby="modalSeleccionarPrestamoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalSeleccionarPrestamoLabel">
                        <i class="fas fa-list-alt mr-2"></i>Seleccionar Préstamo para Precancelar
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
                                    <th>ID Préstamo</th>
                                    <th>Monto Total</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="prestamosBody">
                                <!-- Préstamos se cargarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Precancelación -->
    <div class="modal fade" id="modalPrecancelarPrestamo" tabindex="-1" role="dialog"
        aria-labelledby="modalPrecancelarPrestamoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPrecancelarPrestamoLabel">
                        <i class="fas fa-list-alt mr-2"></i>Confirmar Precancelación de Préstamo
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
                                    <th>ID Préstamo</th>
                                    <th>Detalle</th>
                                    <th>Capital</th>
                                    <th>Interés</th>
                                    <th>Monto Total</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Multa</th>
                                </tr>
                            </thead>
                            <tbody id="cuotasPrecancelarBody">
                                <!-- Cuotas pendientes para precancelar se cargarán aquí -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <h5>Costo Total de Precancelación: <span id="costoPrecancelacion">0</span></h5>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmarPrecancelar">
                        <i class="fas fa-check mr-1"></i> Confirmar Precancelación
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

        // Almacenar las cuotas seleccionadas y el ID del préstamo asociado
        let cuotasSeleccionadas = [];
        let prestamoIdAsociado = null; // Guardar el ID del préstamo asociado a las cuotas
        let multaConfig = parseFloat("{{ $configuracion->valor_mora ?? 0 }}");
        console.log('Multa configurada:', multaConfig);
        let clienteIdSeleccionado = null;
        let prestamosCliente = [];

        // Cargar datos del cliente y cuotas/ahorros al seleccionar un cliente
        $('#cliente_id').on('change', function() {
            // Reiniciar todas las variables al cambiar de cliente
            cuotasSeleccionadas = [];
            prestamoIdAsociado = null;
            window.cuotasPendientes = [];
            window.ahorrosPendientes = [];
            prestamosCliente = [];
            clienteIdSeleccionado = $(this).val();

            // Limpiar la tabla de cuotas seleccionadas
            actualizarTablaCuotasSeleccionadas();

            if (clienteIdSeleccionado) {
                // Obtener datos del cliente
                $.ajax({
                    url: "{{ url('/admin/cuotas/cliente') }}/" + clienteIdSeleccionado,
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

                        // Cargar cuotas pendientes
                        $.ajax({
                            url: "{{ url('/admin/cuotas/pagos-pendientes') }}/" + clienteIdSeleccionado,
                            type: 'GET',
                            success: function(pagos) {
                                console.log('Datos de pagos (préstamos) recibidos:', pagos);
                                window.cuotasPendientes = [];
                                const fechaActual = new Date();

                                // Filtrar cuotas pendientes (atrasadas y del mes actual hasta el día 10)
                                pagos.forEach(function(pago) {
                                    const fechaVencimiento = new Date(pago.fecha_vencimiento);
                                    const mesActual = fechaActual.getMonth();
                                    const anioActual = fechaActual.getFullYear();
                                    const diaActual = fechaActual.getDate();

                                    const mesVencimiento = fechaVencimiento.getMonth();
                                    const anioVencimiento = fechaVencimiento.getFullYear();

                                    // Incluir cuotas atrasadas (fecha de vencimiento anterior a la fecha actual)
                                    // O incluir cuotas del mes actual si estamos entre el 1 y el 10 del mes
                                    if (
                                        fechaVencimiento <= fechaActual || // Cuotas atrasadas
                                        (mesVencimiento === mesActual && anioVencimiento === anioActual && diaActual <= 10) // Cuotas del mes actual hasta el día 10
                                    ) {
                                        window.cuotasPendientes.push(pago);
                                    }
                                });
                            },
                            error: function(xhr) {
                                console.log('Error al obtener pagos de préstamos:', xhr.responseText);
                                alert("No se pudo obtener los pagos pendientes del cliente");
                            }
                        });

                        // Cargar ahorros pendientes
                        $.ajax({
                            url: "{{ url('/admin/cuotas/ahorros-pendientes') }}/" + clienteIdSeleccionado,
                            type: 'GET',
                            success: function(ahorros) {
                                console.log('Datos de ahorros recibidos:', ahorros);
                                window.ahorrosPendientes = [];
                                const fechaActual = new Date();

                                // Filtrar ahorros pendientes (atrasados y del mes actual hasta el día 10)
                                ahorros.forEach(function(ahorro) {
                                    const fechaVencimiento = ahorro.fecha_vencimiento ? new Date(ahorro.fecha_vencimiento) : null;
                                    if (fechaVencimiento) {
                                        const mesActual = fechaActual.getMonth();
                                        const anioActual = fechaActual.getFullYear();
                                        const diaActual = fechaActual.getDate();

                                        const mesVencimiento = fechaVencimiento.getMonth();
                                        const anioVencimiento = fechaVencimiento.getFullYear();

                                        // Incluir ahorros atrasados (fecha de vencimiento anterior a la fecha actual)
                                        // O incluir ahorros del mes actual si estamos entre el 1 y el 10 del mes
                                        if (
                                            fechaVencimiento <= fechaActual || // Ahorros atrasados
                                            (mesVencimiento === mesActual && anioVencimiento === anioActual && diaActual <= 10) // Ahorros del mes actual hasta el día 10
                                        ) {
                                            window.ahorrosPendientes.push(ahorro);
                                        }
                                    }
                                });
                            },
                            error: function(xhr) {
                                console.log('Error al obtener ahorros:', xhr.responseText);
                                alert("No se pudo obtener los ahorros pendientes del cliente");
                            }
                        });

                        // Cargar préstamos del cliente para el modal de selección
                        $.ajax({
                            url: "{{ url('/admin/cuotas/clientes-prestamos') }}/" + clienteIdSeleccionado,
                            type: 'GET',
                            success: function(prestamos) {
                                console.log('Préstamos recibidos:', prestamos);
                                prestamosCliente = prestamos;
                                var prestamosBody = $('#prestamosBody');
                                prestamosBody.empty();
                                // Contar los préstamos y asignar a una variable
                                var totalPrestamos = prestamos.length;
                                if (totalPrestamos === 0) {
                                    prestamosBody.append(
                                        '<tr><td colspan="4">No hay préstamos activos para este cliente.</td></tr>'
                                    );
                                    $("#prestamos_activos").text('Ninguno');
                                } else {
                                    prestamos.forEach(function(prestamo) {
                                        prestamosBody.append(
                                            '<tr>' +
                                            '<td>' + (prestamo.id || 'N/A') + '</td>' +
                                            '<td>' + (prestamo.monto_total || '0') + '</td>' +
                                            '<td>' + (prestamo.fecha_inicio || 'N/A') + '</td>' +
                                            '<td><button type="button" class="btn btn-primary btn-sm seleccionar-prestamo" data-prestamo-id="' +
                                            prestamo.id +
                                            '">Seleccionar</button></td>' +
                                            '</tr>'
                                        );
                                    });
                                    $("#prestamos_activos").text(
                                        `${totalPrestamos} préstamo${totalPrestamos !== 1 ? 's' : ''}`
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.log('Error al obtener préstamos:', xhr.responseText);
                                alert("No se pudo obtener los préstamos del cliente");
                                $("#prestamos_activos").text('Error al cargar');
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
            }
        });

        // Manejar la selección de un préstamo para precancelar
        $(document).on('click', '.seleccionar-prestamo', function() {
            var prestamoId = $(this).data('prestamo-id');
            $('#modalSeleccionarPrestamo').modal('hide');

            // Verificar si ya hay cuotas de un préstamo diferente
            if (prestamoIdAsociado && prestamoIdAsociado != prestamoId) {
                alert(
                    "No se puede precancelar un préstamo diferente. Solo se permite manejar cuotas de un préstamo a la vez."
                );
                return;
            }

            // Cargar las cuotas del préstamo seleccionado para el modal de precancelación
            $.ajax({
                url: "{{ url('/admin/cuotas/pagos-pendientes') }}/" + clienteIdSeleccionado,
                type: 'GET',
                success: function(pagos) {
                    console.log('Datos de pagos (préstamos) recibidos:', pagos);
                    var cuotasPrecancelarBody = $('#cuotasPrecancelarBody');
                    cuotasPrecancelarBody.empty();
                    let costoTotalPrecancelacion = 0;
                    let cuotasPrestamo = pagos.filter(pago => pago.prestamo_id == prestamoId);

                    if (cuotasPrestamo.length === 0) {
                        cuotasPrecancelarBody.append(
                            '<tr><td colspan="7">No hay cuotas pendientes para este préstamo.</td></tr>'
                        );
                    } else {
                        cuotasPrestamo.forEach(function(pago) {
                            const fechaVencimiento = new Date(pago.fecha_vencimiento);
                            const fechaActual = new Date();
                            const mesActual = fechaActual.getMonth();
                            const anioActual = fechaActual.getFullYear();
                            const diaActual = fechaActual.getDate();
                            const mesVencimiento = fechaVencimiento.getMonth();
                            const anioVencimiento = fechaVencimiento.getFullYear();

                            let multa = 0;
                            let monto = 0;

                            // Cuota atrasada: antes del mes actual
                            if (
                                anioVencimiento < anioActual ||
                                (anioVencimiento === anioActual && mesVencimiento < mesActual)
                            ) {
                                multa = multaConfig; // Multa para cuotas atrasadas
                                monto = parseFloat(pago.monto); // Capital + interés
                            }
                            // Cuota del mes actual (entre el 1 y el 10): incluir interés, sin multa
                            else if (
                                mesVencimiento === mesActual &&
                                anioVencimiento === anioActual &&
                                diaActual <= 10
                            ) {
                                multa = 0; // Sin multa
                                monto = parseFloat(pago.monto); // Capital + interés
                            }
                            // Cuota futura: después del mes actual
                            else {
                                multa = 0; // Sin multa
                                monto = parseFloat(pago.capital); // Solo capital
                            }

                            const total = monto + multa;

                            costoTotalPrecancelacion += total;

                            cuotasPrecancelarBody.append(
                                '<tr>' +
                                '<td>' + (pago.prestamo_id || 'N/A') + '</td>' +
                                '<td>' + (pago.detalle || 'Sin detalle') + '</td>' +
                                '<td>' + parseFloat(pago.capital).toFixed(2) + '</td>' +
                                '<td>' + parseFloat(pago.interes).toFixed(2) + '</td>' +
                                '<td>' + parseFloat(pago.monto).toFixed(2) + '</td>' +
                                '<td>' + (pago.fecha_vencimiento || 'N/A') + '</td>' +
                                '<td>' + multa.toFixed(2) + '</td>' +
                                '</tr>'
                            );
                        });
                        $('#costoPrecancelacion').text(costoTotalPrecancelacion.toFixed(2));
                        window.cuotasPrecancelar = cuotasPrestamo; // Guardar las cuotas para usarlas al confirmar
                        window.prestamoIdPrecancelar = prestamoId; // Guardar el ID del préstamo para la precancelación
                    }
                    $('#modalPrecancelarPrestamo').modal('show');
                },
                error: function(xhr) {
                    console.log('Error al obtener pagos de préstamos:', xhr.responseText);
                    alert("No se pudo obtener los pagos pendientes del cliente");
                }
            });
        });

        // Confirmar precancelación
        $('#confirmarPrecancelar').on('click', function() {
            if (window.cuotasPrecancelar && window.cuotasPrecancelar.length > 0) {
                // Verificar si ya hay cuotas de un préstamo diferente
                if (prestamoIdAsociado && prestamoIdAsociado != window.prestamoIdPrecancelar) {
                    alert(
                        "No se puede precancelar un préstamo diferente. Solo se permite manejar cuotas de un préstamo a la vez."
                    );
                    $('#modalPrecancelarPrestamo').modal('hide');
                    return;
                }

                // Verificar si ya hay cuotas de préstamo o ahorro seleccionadas
                let tieneAhorro = cuotasSeleccionadas.some(item => item.transaccion === 'Ahorro');
                let tienePrestamo = cuotasSeleccionadas.some(item => item.transaccion === 'Préstamo');

                if (tieneAhorro || tienePrestamo) {
                    alert(
                        "No se puede realizar una precancelación porque ya hay cuotas de préstamo o ahorro seleccionadas. Complete o elimine las cuotas actuales primero."
                    );
                    $('#modalPrecancelarPrestamo').modal('hide');
                    return;
                }

                let nuevasCuotas = [];
                let costoTotalPrecancelacion = 0;

                window.cuotasPrecancelar.forEach(function(pago) {
                    const fechaVencimiento = new Date(pago.fecha_vencimiento);
                    const fechaActual = new Date();
                    const mesActual = fechaActual.getMonth();
                    const anioActual = fechaActual.getFullYear();
                    const diaActual = fechaActual.getDate();
                    const mesVencimiento = fechaVencimiento.getMonth();
                    const anioVencimiento = fechaVencimiento.getFullYear();

                    let multa = 0;
                    let monto = 0;

                    // Cuota atrasada: antes del mes actual
                    if (
                        anioVencimiento < anioActual ||
                        (anioVencimiento === anioActual && mesVencimiento < mesActual)
                    ) {
                        multa = multaConfig; // Multa para cuotas atrasadas
                        monto = parseFloat(pago.monto); // Capital + interés
                    }
                    // Cuota del mes actual (entre el 1 y el 10): incluir interés, sin multa
                    else if (
                        mesVencimiento === mesActual &&
                        anioVencimiento === anioActual &&
                        diaActual <= 10
                    ) {
                        multa = 0; // Sin multa
                        monto = parseFloat(pago.monto); // Capital + interés
                    }
                    // Cuota futura: después del mes actual
                    else {
                        multa = 0; // Sin multa
                        monto = parseFloat(pago.capital); // Solo capital
                    }

                    const total = monto + multa;

                    costoTotalPrecancelacion += total;

                    nuevasCuotas.push({
                        id: pago.id,
                        id_compuesto: `precancelacion-${pago.id}`, // ID compuesto para precancelación
                        transaccion: pago.transaccion,
                        detalle: pago.detalle,
                        fecha_vencimiento: pago.fecha_vencimiento,
                        monto: monto,
                        multa: multa,
                        total: total,
                        prestamo_id: pago.prestamo_id
                    });
                });

                if (confirm(
                        `El costo total de la precancelación es ${costoTotalPrecancelacion.toFixed(2)}. ¿Desea continuar?`
                    )) {
                    prestamoIdAsociado = window.prestamoIdPrecancelar; // Asignar el ID del préstamo asociado
                    cuotasSeleccionadas = [...cuotasSeleccionadas, ...nuevasCuotas];
                    actualizarTablaCuotasSeleccionadas();
                    $('#modalPrecancelarPrestamo').modal('hide');
                }
            } else {
                alert("No hay cuotas para precancelar.");
            }
        });

        // Cargar Pago de Préstamo (Mes Actual y Atrasados)
        $('#pagoPrestamoMesActual').on('click', function() {
            if (window.cuotasPendientes && window.cuotasPendientes.length > 0) {
                // Verificar si ya hay una precancelación seleccionada
                let tienePrecancelacion = cuotasSeleccionadas.some(item => item.id_compuesto.startsWith('precancelacion'));

                if (tienePrecancelacion) {
                    alert(
                        "No se puede cargar cuotas de préstamo porque ya hay una precancelación seleccionada. Complete o elimine la precancelación primero."
                    );
                    return;
                }

                // Obtener la fecha de pago seleccionada
                const fechaPago = new Date($('#fecha_pago').val());

                let nuevasCuotas = [];
                window.cuotasPendientes.forEach(function(cuota) {
                    // Verificar si la cuota ya está en cuotasSeleccionadas
                    const yaExiste = cuotasSeleccionadas.some(
                        item => item.id_compuesto === `cuota-${cuota.id}`
                    );

                    if (!yaExiste) {
                        const fechaVencimiento = new Date(cuota.fecha_vencimiento);
                        let multa = 0;

                        // Determinar el límite del día 10 del mes de vencimiento
                        const mesVencimiento = fechaVencimiento.getMonth();
                        const anioVencimiento = fechaVencimiento.getFullYear();
                        const fechaLimite = new Date(anioVencimiento, mesVencimiento, 10); // Día 10 del mes de vencimiento

                        // Si la fecha de pago es posterior al día 10 del mes de vencimiento, se aplica multa
                        if (fechaPago > fechaLimite) {
                            multa = multaConfig;
                        }

                        const monto = parseFloat(cuota.monto);
                        const total = monto + multa;

                        nuevasCuotas.push({
                            id: cuota.id,
                            id_compuesto: `cuota-${cuota.id}`, // ID compuesto para cuota de préstamo
                            transaccion: cuota.transaccion,
                            detalle: cuota.detalle,
                            fecha_vencimiento: cuota.fecha_vencimiento,
                            monto: monto,
                            montoOriginal: monto, // Guardar el monto original
                            multa: multa,
                            total: total,
                            prestamo_id: cuota.prestamo_id,
                            modificado: false // Inicialmente no modificado
                        });
                    }
                });

                if (nuevasCuotas.length > 0) {
                    // Agregar las nuevas cuotas a las seleccionadas
                    cuotasSeleccionadas = [...cuotasSeleccionadas, ...nuevasCuotas];
                    actualizarTablaCuotasSeleccionadas();
                } else {
                    alert("Todas las cuotas de préstamo pendientes ya están cargadas.");
                }
            } else {
                alert("No hay cuotas de préstamo pendientes hasta el mes actual.");
            }
        });

        // Cargar Pago de Ahorro (Mes Actual y Atrasados)
        $('#pagoAhorroMesActual').on('click', function() {
            if (window.ahorrosPendientes && window.ahorrosPendientes.length > 0) {
                // Verificar si ya hay una precancelación seleccionada
                let tienePrecancelacion = cuotasSeleccionadas.some(item => item.id_compuesto.startsWith('precancelacion'));

                if (tienePrecancelacion) {
                    alert(
                        "No se puede cargar cuotas de ahorro porque ya hay una precancelación seleccionada. Complete o elimine la precancelación primero."
                    );
                    return;
                }

                // Obtener la fecha de pago seleccionada
                const fechaPago = new Date($('#fecha_pago').val());

                let nuevasCuotas = [];
                window.ahorrosPendientes.forEach(function(ahorro) {
                    // Verificar si el ahorro ya está en cuotasSeleccionadas
                    const yaExiste = cuotasSeleccionadas.some(
                        item => item.id_compuesto === `ahorro-${ahorro.id}`
                    );

                    if (!yaExiste) {
                        const fechaVencimiento = ahorro.fecha_vencimiento ? new Date(ahorro.fecha_vencimiento) : null;
                        let multa = 0;

                        if (fechaVencimiento) {
                            // Determinar el límite del día 10 del mes de vencimiento
                            const mesVencimiento = fechaVencimiento.getMonth();
                            const anioVencimiento = fechaVencimiento.getFullYear();
                            const fechaLimite = new Date(anioVencimiento, mesVencimiento, 10); // Día 10 del mes de vencimiento

                            // Si la fecha de pago es posterior al día 10 del mes de vencimiento, se aplica multa
                            if (fechaPago > fechaLimite) {
                                multa = multaConfig;
                            }
                        }

                        const monto = parseFloat(ahorro.monto);
                        const total = monto + multa;

                        nuevasCuotas.push({
                            id: ahorro.id,
                            id_compuesto: `ahorro-${ahorro.id}`, // ID compuesto para ahorro
                            transaccion: ahorro.transaccion,
                            detalle: ahorro.detalle,
                            fecha_vencimiento: ahorro.fecha_vencimiento || 'N/A',
                            monto: monto,
                            montoOriginal: monto, // Guardar el monto original
                            multa: multa,
                            total: total,
                            prestamo_id: null, // Ahorros no tienen préstamo asociado
                            modificado: false // Inicialmente no modificado
                        });
                    }
                });

                if (nuevasCuotas.length > 0) {
                    cuotasSeleccionadas = [...cuotasSeleccionadas, ...nuevasCuotas];
                    actualizarTablaCuotasSeleccionadas();
                } else {
                    alert("Todos los ahorros pendientes ya están cargados.");
                }
            } else {
                alert("No hay ahorros pendientes hasta el mes actual.");
            }
        });

        // Manejar la eliminación de una cuota de la tabla
        $(document).on('click', '.eliminar-cuota', function() {
            var index = $(this).data('index');
            cuotasSeleccionadas.splice(index, 1);

            // Si no quedan cuotas de préstamo, liberar el prestamoIdAsociado
            let tienePrestamo = cuotasSeleccionadas.some(item => item.transaccion === 'Préstamo');
            if (!tienePrestamo) {
                prestamoIdAsociado = null;
            }

            actualizarTablaCuotasSeleccionadas();
        });

        function actualizarTablaCuotasSeleccionadas() {
            var cuotasSeleccionadasBody = $('#cuotasSeleccionadasBody');
            cuotasSeleccionadasBody.empty();

            if (cuotasSeleccionadas.length === 0) {
                cuotasSeleccionadasBody.append('<tr><td colspan="7">No hay cuotas seleccionadas.</td></tr>');
            } else {
                cuotasSeleccionadas.forEach(function(item, index) {
                    // Determinar si es una cuota de precancelación
                    const esPrecancelacion = item.id_compuesto.startsWith('precancelacion');
                    const botonEliminar = esPrecancelacion ?
                        `<button type="button" class="btn btn-danger btn-sm eliminar-cuota" data-index="${index}" disabled>Eliminar</button>` :
                        `<button type="button" class="btn btn-danger btn-sm eliminar-cuota" data-index="${index}">Eliminar</button>`;

                    // Si es precancelación, mostrar monto y multa como texto (no editable)
                    // Si no, mostrar como inputs editables
                    const montoField = esPrecancelacion ?
                        parseFloat(item.monto).toFixed(2) :
                        `<input type="number" class="form-control monto-input" data-index="${index}" value="${parseFloat(item.monto).toFixed(2)}" step="0.01" min="0">`;
                    const multaField = esPrecancelacion ?
                        parseFloat(item.multa).toFixed(2) :
                        `<input type="number" class="form-control multa-input" data-index="${index}" value="${parseFloat(item.multa).toFixed(2)}" step="0.01" min="0">`;

                    cuotasSeleccionadasBody.append(
                        '<tr>' +
                        '<td>' + (item.transaccion || 'Desconocido') + '</td>' +
                        '<td>' + (item.detalle || 'Sin detalle') + '</td>' +
                        '<td>' + (item.fecha_vencimiento || 'N/A') + '</td>' +
                        '<td>' + montoField + '</td>' +
                        '<td>' + multaField + '</td>' +
                        '<td class="total-cuota" data-index="' + index + '">' + parseFloat(item.total).toFixed(2) + '</td>' +
                        '<td>' + botonEliminar + '</td>' +
                        '</tr>'
                    );
                });
            }

            // Actualizar los campos ocultos para el envío al backend
            var pagosSeleccionados = cuotasSeleccionadas.map(item => item.id_compuesto);
            $('#pagos_seleccionados').val(pagosSeleccionados.join(','));

            var montosPagos = cuotasSeleccionadas.map(item => item.monto);
            $('#montos_pagos').val(montosPagos.join(','));

            var multasPagos = cuotasSeleccionadas.map(item => item.multa);
            $('#multas_pagos').val(multasPagos.join(','));

            var totalMonto = cuotasSeleccionadas.reduce((sum, item) => sum + parseFloat(item.total), 0);
            $('#totalMonto').text(totalMonto.toFixed(2));
            $('#total_monto').val(totalMonto.toFixed(2));
        }

        // Manejar cambios en el monto
        $(document).on('change', '.monto-input', function() {
            const index = $(this).data('index');
            const nuevoMonto = parseFloat($(this).val()) || 0;

            // Actualizar el monto y el total
            const cuota = cuotasSeleccionadas[index];
            const montoOriginal = parseFloat(cuota.montoOriginal || cuota.monto); // Guardar el monto original si no existe

            // Guardar el monto original si no se ha guardado aún
            if (!cuota.montoOriginal) {
                cuota.montoOriginal = montoOriginal;
            }

            // Actualizar el monto
            cuota.monto = nuevoMonto;

            // Si el monto cambió, actualizar el id_compuesto
            if (nuevoMonto !== parseFloat(cuota.montoOriginal)) {
                const partes = cuota.id_compuesto.split('-');
                const tipo = partes[0]; // "ahorro" o "cuota"
                const id = partes[partes.length - 1]; // El ID (por ejemplo, "12")
                cuota.id_compuesto = `${tipo}-modificado-${id}`;
                cuota.modificado = true; // Marcar como modificado
            } else {
                // Si el monto vuelve al original, revertir el id_compuesto
                const partes = cuota.id_compuesto.split('-');
                const tipo = partes[0]; // "ahorro" o "cuota"
                const id = partes[partes.length - 1]; // El ID (por ejemplo, "12")
                cuota.id_compuesto = `${tipo}-${id}`;
                cuota.modificado = false;
            }

            // Actualizar el total
            cuota.total = nuevoMonto + parseFloat(cuota.multa);

            // Actualizar la tabla
            $(`tr .total-cuota[data-index="${index}"]`).text(parseFloat(cuota.total).toFixed(2));

            // Actualizar los campos ocultos
            var pagosSeleccionados = cuotasSeleccionadas.map(item => item.id_compuesto);
            $('#pagos_seleccionados').val(pagosSeleccionados.join(','));

            var montosPagos = cuotasSeleccionadas.map(item => item.monto);
            $('#montos_pagos').val(montosPagos.join(','));

            var totalMonto = cuotasSeleccionadas.reduce((sum, item) => sum + parseFloat(item.total), 0);
            $('#totalMonto').text(totalMonto.toFixed(2));
            $('#total_monto').val(totalMonto.toFixed(2));
        });

        // Manejar cambios en la multa
        $(document).on('change', '.multa-input', function() {
            const index = $(this).data('index');
            const nuevaMulta = parseFloat($(this).val()) || 0;

            // Actualizar la multa y el total
            const cuota = cuotasSeleccionadas[index];
            cuota.multa = nuevaMulta;
            cuota.total = parseFloat(cuota.monto) + nuevaMulta;

            // Actualizar la tabla
            $(`tr .total-cuota[data-index="${index}"]`).text(parseFloat(cuota.total).toFixed(2));

            // Actualizar los campos ocultos
            var multasPagos = cuotasSeleccionadas.map(item => item.multa);
            $('#multas_pagos').val(multasPagos.join(','));

            var totalMonto = cuotasSeleccionadas.reduce((sum, item) => sum + parseFloat(item.total), 0);
            $('#totalMonto').text(totalMonto.toFixed(2));
            $('#total_monto').val(totalMonto.toFixed(2));
        });
    });
</script>
@endsection