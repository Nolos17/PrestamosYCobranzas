@extends('layouts.admin')

@section('content_header')
<h1><b>Registro de Préstamo</b></h1>
<p><strong>Saldo Disponible: </strong><span id="saldoDisponible">{{ $saldo }}</span></p>
@stop

@section('content')
<form id="prestamoForm" action="{{ route('admin.prestamos.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
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
                                    <select name="cliente_id" id="cliente_id" class="form-control select2" required>
                                        <option value="">Buscar Cliente...</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- Sección de datos del cliente, oculta hasta que se seleccione un cliente -->
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
                                    <label><i class="fas fa-user"></i> Apellidos:</label>
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
                                    <input type="date" id="fecha_afiliacion_hidden" name="fecha_afiliacion" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-user"></i> Nro de Acciones:</label>
                                    <span id="acciones"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-user"></i> Ahorro Disponible:</label>
                                    <span id="saldo_ahorro"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>

    <div class="row" id="prestamo" style="display: none;">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Datos del Préstamo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="monto_prestado">Monto del Préstamo</label>
                                <input type="number" name="monto_prestado" id="monto_prestado" class="form-control" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="metodo_prestamo">Tipo de Préstamo</label>
                                <select name="metodo_prestamo" id="metodo_prestamo" class="form-control" onchange="toggleInteresInput();">
                                    <option value="Personalizado">Personalizado</option>
                                    <option value="Francés">Francés</option>
                                    <option value="Alemán">Alemán</option>
                                    <option value="Institucional" selected>Institucional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="interesPersonalizado" style="display: none;">
                            <div class="form-group">
                                <label for="interes_personalizado">Interés Mensual (%)</label>
                                <input type="number" name="interes_personalizado" id="interes_personalizado" class="form-control" step="0.01" placeholder="Ingrese el interés" value="{{ $configuracion->base_prestamo }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <select name="modalidad" id="modalidad" class="form-control">
                                    <option value="Diario">Diario</option>
                                    <option value="Semanal">Semanal</option>
                                    <option value="Quincenal">Quincenal</option>
                                    <option value="Mensual" selected>Mensual</option>
                                    <option value="Anual">Anual</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nro_cuotas">Nro de Cuotas</label>
                                <input type="number" name="nro_cuotas" id="nro_cuotas" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_prestamo">Fecha de Préstamo</label>
                                <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div style="height: 8px;"></div>
                                <button class="btn btn-success" type="button" onclick="validarMonto();"><i class="fas fa-calculator"></i> Calcular Préstamo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo oculto para las cuotas -->
    <input type="hidden" name="cuotas_json" id="cuotas_json">
    <!-- Campo oculto para el monto total -->
    <input type="hidden" name="monto_total" id="totalPagarInput">

    <!-- Modal para mostrar detalles de cuotas -->
    <div class="modal fade" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="modalCuotasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCuotasLabel">Detalles de Cuotas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Número de Cuota</th>
                                <th>Monto de Cuota</th>
                                <th>Interés Generado</th>
                                <th>Capital Pagado</th>
                                <th>Saldo Capital</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCuotas">
                            <!-- Las filas se llenarán dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <p><strong>Total a Pagar: </strong><span id="totalPagar"></span></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="aprobarPrestamo">Aprobar Préstamo</button>
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@section('css')
<style>
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
</style>
@stop

@section('js')
<script>
    $('.select2').select2({});

    $('.select2').on('change', function() {
        var id = $(this).val();
        if (id) {
            $.ajax({
                url: "{{ url('/admin/prestamos/cliente/') }}/" + id,
                type: 'GET',
                success: function(cliente) {
                    $("#contenido-cliente").css('display', 'block');
                    $("#nro_documento").text(cliente.nro_documento);
                    $("#apellidos").text(cliente.apellidos + ' ' + cliente.nombres);
                    $("#celular").text(cliente.celular);
                    $("#fecha_afiliacion").text(cliente.fecha_afiliacion);
                    $("#acciones").text(cliente.acciones);
                    $("#saldo_ahorro").text(cliente.saldo_ahorro);
                    $("#fecha_afiliacion_hidden").val(cliente.fecha_afiliacion);

                    // Verificar la antigüedad después de cargar los datos
                    verificarAntiguedad();
                },
                error: function() {
                    alert("No se pudo obtener la información del cliente");
                }
            });
        }
    });

    // Función para verificar la antigüedad
    function verificarAntiguedad() {
        var fechaAfiliacionStr = document.getElementById('fecha_afiliacion_hidden').value;
        if (!fechaAfiliacionStr) {
            console.log("No se ha proporcionado una fecha de afiliación.");
            return;
        }

        var fechaAfiliacion = new Date(fechaAfiliacionStr);
        var fechaActual = new Date();

        var diffAños = fechaActual.getFullYear() - fechaAfiliacion.getFullYear();
        var diffMeses = fechaActual.getMonth() - fechaAfiliacion.getMonth();
        var totalMeses = diffAños * 12 + diffMeses;

        if (fechaActual.getDate() < fechaAfiliacion.getDate()) {
            totalMeses--;
        }

        var prestamo = document.getElementById('prestamo');
        if (totalMeses < 5) {
            mostrarMensajeAdvertencia();
            prestamo.style.display = 'none';
        } else {
            ocultarMensajeAdvertencia();
            prestamo.style.display = 'block';
        }
    }

    // Función para mostrar el mensaje de advertencia
    function mostrarMensajeAdvertencia() {
        var mensajeAprobado = document.getElementById('mensaje-aprobado');
        if (mensajeAprobado) {
            mensajeAprobado.style.display = 'none';
        }

        var mensaje = document.getElementById('mensaje-antiguedad');
        if (!mensaje) {
            mensaje = document.createElement('div');
            mensaje.id = 'mensaje-antiguedad';
            mensaje.style.color = 'red';
            mensaje.style.fontSize = '20px';
            mensaje.style.marginTop = '10px';
            mensaje.innerText = 'NO SE LE PUEDE DAR UN PRÉSTAMO POR ANTIGÜEDAD';
            var contenedor = document.getElementById('contenido-cliente');
            contenedor.appendChild(mensaje);
        }
        mensaje.style.display = 'block';
    }

    // Función para ocultar el mensaje de advertencia
    function ocultarMensajeAdvertencia() {
        var mensaje = document.getElementById('mensaje-antiguedad');
        if (mensaje) {
            mensaje.style.display = 'none';
        }

        var mensajeAprobado = document.getElementById('mensaje-aprobado');
        if (!mensajeAprobado) {
            mensajeAprobado = document.createElement('div');
            mensajeAprobado.id = 'mensaje-aprobado';
            mensajeAprobado.style.color = 'green';
            mensajeAprobado.style.fontSize = '20px';
            mensajeAprobado.style.marginTop = '10px';
            mensajeAprobado.innerText = 'CUMPLE LOS REQUISITOS PARA OBTENER UN PRÉSTAMO';
            var contenedor = document.getElementById('contenido-cliente');
            contenedor.appendChild(mensajeAprobado);
        }
        mensajeAprobado.style.display = 'block';
    }

    // Validar el monto del préstamo
    function validarMonto() {
        var montoSolicitado = parseFloat(document.getElementById('monto_prestado').value);
        var saldoDisponible = parseFloat("{{ $saldo }}");

        if (isNaN(montoSolicitado) || montoSolicitado <= 0) {
            alert("Por favor, ingrese un monto válido para el préstamo.");
            return;
        }

        if (montoSolicitado > saldoDisponible) {
            alert("El monto solicitado no puede ser mayor que el saldo disponible.");
        } else {
            calcularPrestamo();
        }
    }

    // Calcular el préstamo
    function calcularPrestamo() {
        // Obtener valores del formulario
        const montoPrestado = parseFloat(document.getElementById('monto_prestado').value);
        const metodoPrestamo = document.getElementById('metodo_prestamo').value;
        const modalidad = document.getElementById('modalidad').value;
        const nroCuotas = parseInt(document.getElementById('nro_cuotas').value);
        const fechaPrestamo = document.getElementById('fecha_prestamo').value;

        // Validar entradas básicas
        if (isNaN(montoPrestado) || isNaN(nroCuotas) || montoPrestado <= 0 || nroCuotas <= 0) {
            alert("Por favor, ingrese valores válidos para el monto y el número de cuotas.");
            return;
        }

        // Definir tasas de interés según el método
        let tasaInteresAnual;
        if (metodoPrestamo === 'Personalizado') {
            const interesPersonalizado = parseFloat(document.getElementById('interes_personalizado').value);
            if (isNaN(interesPersonalizado) || interesPersonalizado < 0) {
                alert("Por favor, ingrese un valor válido para el interés personalizado.");
                return;
            }
            tasaInteresAnual = (interesPersonalizado / 100) * 12; // Convertir porcentaje mensual a anual
        } else {
            tasaInteresAnual = (parseFloat("{{ $configuracion->base_prestamo }}") / 100) * 12; // Usar la tasa base de Configuración
        }

        // Ajustar la tasa según la modalidad
        let tasaAjustada = 0;
        switch (modalidad) {
            case "Diario":
                tasaAjustada = tasaInteresAnual / 360;
                break;
            case "Semanal":
                tasaAjustada = tasaInteresAnual / 52;
                break;
            case "Quincenal":
                tasaAjustada = tasaInteresAnual / 24;
                break;
            case "Mensual":
                tasaAjustada = tasaInteresAnual / 12;
                break;
            case "Anual":
                tasaAjustada = tasaInteresAnual;
                break;
            default:
                alert("Modalidad no válida.");
                return;
        }

        // Calcular las cuotas detalladas según el método
        let cuotasDetalladas = [];
        let totalPagar = 0;

        if (metodoPrestamo === 'Personalizado' || metodoPrestamo === 'Institucional') {
            // Cálculo original: interés por cuota basado en el monto inicial
            const interesPorCuota = montoPrestado * tasaAjustada; // Interés fijo por cuota, basado en el monto inicial
            const capitalPorCuota = montoPrestado / nroCuotas; // Capital fijo por cuota
            const cuota = capitalPorCuota + interesPorCuota; // Cuota total = capital + interés
            let saldo = montoPrestado;

            for (let i = 1; i <= nroCuotas; i++) {
                saldo -= capitalPorCuota;
                cuotasDetalladas.push({
                    numero: i,
                    cuota: cuota.toFixed(2),
                    interes: interesPorCuota.toFixed(2),
                    capital: capitalPorCuota.toFixed(2),
                    saldo: saldo.toFixed(2)
                });
                totalPagar += parseFloat(cuota.toFixed(2));
            }
        } else if (metodoPrestamo === 'Francés') {
            const factor = Math.pow(1 + tasaAjustada, nroCuotas);
            const cuota = (montoPrestado * tasaAjustada * factor) / (factor - 1);
            let saldo = montoPrestado;
            for (let i = 1; i <= nroCuotas; i++) {
                const interes = saldo * tasaAjustada;
                const capital = cuota - interes;
                saldo -= capital;
                cuotasDetalladas.push({
                    numero: i,
                    cuota: cuota.toFixed(2),
                    interes: interes.toFixed(2),
                    capital: capital.toFixed(2),
                    saldo: saldo.toFixed(2)
                });
                totalPagar += parseFloat(cuota.toFixed(2));
            }
        } else if (metodoPrestamo === 'Alemán') {
            const amortizacion = montoPrestado / nroCuotas;
            let saldo = montoPrestado;
            for (let i = 1; i <= nroCuotas; i++) {
                const interes = saldo * tasaAjustada;
                const cuotaActual = amortizacion + interes;
                saldo -= amortizacion;
                cuotasDetalladas.push({
                    numero: i,
                    cuota: cuotaActual.toFixed(2),
                    interes: interes.toFixed(2),
                    capital: amortizacion.toFixed(2),
                    saldo: saldo.toFixed(2)
                });
                totalPagar += parseFloat(cuotaActual.toFixed(2));
            }
        }

        // Llenar la tabla del modal con los detalles
        const tablaCuotas = document.getElementById('tablaCuotas');
        tablaCuotas.innerHTML = '';
        cuotasDetalladas.forEach(cuota => {
            const row = `<tr>
                    <td>${cuota.numero}</td>
                    <td>${cuota.cuota}</td>
                    <td>${cuota.interes}</td>
                    <td>${cuota.capital}</td>
                    <td>${cuota.saldo}</td>
                </tr>`;
            tablaCuotas.innerHTML += row;
        });

        // Mostrar el total a pagar global en el modal
        document.getElementById('totalPagar').textContent = totalPagar.toFixed(2);
        document.getElementById('totalPagarInput').value = totalPagar.toFixed(2);

        // Guardar las cuotas en el campo oculto como JSON
        document.getElementById('cuotas_json').value = JSON.stringify(cuotasDetalladas);

        // Mostrar el modal
        $('#modalCuotas').modal('show');
    }

    // Listener para el formulario
    document.getElementById('prestamoForm').addEventListener('submit', function(event) {
        const cuotasJson = document.getElementById('cuotas_json').value;
        if (!cuotasJson) {
            event.preventDefault();
            alert("Por favor, calcule las cuotas antes de aprobar el préstamo.");
        }
    });

    // Mostrar u ocultar el campo de interés personalizado
    function toggleInteresInput() {
        var metodoPrestamo = document.getElementById('metodo_prestamo').value;
        var interesPersonalizado = document.getElementById('interesPersonalizado');
        interesPersonalizado.style.display = metodoPrestamo === 'Personalizado' ? 'block' : 'none';
    }

    // Ejecutar la función al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        toggleInteresInput();
    });
</script>
@stop