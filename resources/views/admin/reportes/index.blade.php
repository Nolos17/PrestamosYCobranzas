@extends('layouts.admin')

@section('content_header')
<h1><b>REPORTES</b></h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Reporte de Transacciones</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-primary w-100"
                            onclick="mostrarSelect('mensual', 'transacciones')">
                            <img src="{{ asset('img/mes.gif') }}" class="icon-img" alt="Mensual"> Mensual
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-primary w-100"
                            onclick="mostrarSelect('anual', 'transacciones')">
                            <img src="{{ asset('img/año.gif') }}" class="icon-img" alt="Anual"> Anual
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-primary w-100"
                            onclick="mostrarSelect('global', 'transacciones')">
                            <img src="{{ asset('img/lupa_global.gif') }}" class="icon-img" alt="Global"> Global
                        </button>
                    </div>
                </div>

                <!-- Formulario para Mensual -->
                <form id="form-mensual-transacciones" action="{{ url('/admin/reportes/transacciones') }}"
                    method="GET" target="_blank" style="display: none;">
                    <input type="hidden" name="tipo_reporte" value="mensual">
                    <div class="form-group">
                        <label for="mes_transacciones">Seleccione el mes:</label>
                        <select name="mes" id="mes_transacciones" class="form-control"
                            onchange="mostrarTipoTransaccion('mensual', 'transacciones')">
                            <option value="">Seleccione un mes</option>
                            @foreach ($meses as $value => $nombre)
                            <option value="{{ $anioActual }}-{{ $value }}">
                                {{ $nombre }} {{ $anioActual }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="tipo_transaccion_mensual_container" style="display: none;">
                        <label for="tipo_transaccion_mensual">Tipo de Transacción:</label>
                        <select name="tipo_transaccion" id="tipo_transaccion_mensual" class="form-control"
                            onchange="mostrarTipoTransaccion1('mensual', 'transacciones')">
                            <option value="">Seleccione tipo</option>
                            <option value="TODOS">TODOS</option>
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                        </select>
                    </div>
                    <div class="form-group" id="tipo_transaccion1_mensual_container" style="display: none;">
                        <label for="tipo_transaccion1_mensual">Detalle de Transacción:</label>
                        <select name="tipo_transaccion1" id="tipo_transaccion1_mensual" class="form-control">
                            <option value="">Seleccione detalle</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="submit_mensual"
                        style="display: none;">Generar Mensual</button>
                </form>

                <!-- Formulario para Anual -->
                <form id="form-anual-transacciones" action="{{ url('/admin/reportes/transacciones') }}"
                    method="GET" target="_blank" style="display: none;">
                    <input type="hidden" name="tipo_reporte" value="anual">
                    <div class="form-group">
                        <label for="anio_transacciones">Seleccione el año:</label>
                        <select name="anio" id="anio_transacciones" class="form-control"
                            onchange="mostrarTipoTransaccion('anual', 'transacciones')">
                            <option value="">Seleccione un año</option>
                            @for ($year = $anioActual; $year >= 2010; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group" id="tipo_transaccion_anual_container" style="display: none;">
                        <label for="tipo_transaccion_anual">Tipo de Transacción:</label>
                        <select name="tipo_transaccion" id="tipo_transaccion_anual" class="form-control"
                            onchange="mostrarTipoTransaccion1('anual', 'transacciones')">
                            <option value="">Seleccione tipo</option>
                            <option value="TODOS">TODOS</option>
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                        </select>
                    </div>
                    <div class="form-group" id="tipo_transaccion1_anual_container" style="display: none;">
                        <label for="tipo_transaccion1_anual">Detalle de Transacción:</label>
                        <select name="tipo_transaccion1" id="tipo_transaccion1_anual" class="form-control">
                            <option value="">Seleccione detalle</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="submit_anual"
                        style="display: none;">Generar Anual</button>
                </form>

                <!-- Formulario para Global -->
                <form id="form-global-transacciones" action="{{ url('/admin/reportes/transacciones') }}"
                    method="GET" target="_blank" style="display: none;">
                    <input type="hidden" name="tipo_reporte" value="global">
                    <div class="form-group">
                        <label for="tipo_transaccion_global">Tipo de Transacción:</label>
                        <select name="tipo_transaccion" id="tipo_transaccion_global" class="form-control"
                            onchange="mostrarTipoTransaccion1('global', 'transacciones')">
                            <option value="">Seleccione tipo</option>
                            <option value="TODOS">TODOS</option>
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                        </select>
                    </div>
                    <div class="form-group" id="tipo_transaccion1_global_container" style="display: none;">
                        <label for="tipo_transaccion1_global">Detalle de Transacción:</label>
                        <select name="tipo_transaccion1" id="tipo_transaccion1_global" class="form-control">
                            <option value="">Seleccione detalle</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="submit_global"
                        style="display: none;">Generar Global</button>
                </form>

                <div class="text-center mt-3">
                    <b>{{ $total_transacciones }} Transacciones</b>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<style>
    .info-box {
        padding: 20px;
        font-size: 18px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .info-box input[type="text"] {
        font-size: 16px;
        height: 40px;
    }

    .icon-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .report-options {
        gap: 20px;
    }

    .report-item {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .report-item:hover {
        background-color: #e9ecef;
    }

    .info-box label {
        font-size: 16px;
        line-height: 40px;
        margin-bottom: 0;
        color: #000;
    }

    .info-box span {
        font-size: 16px;
        line-height: 40px;
        color: #000;
    }

    .custom-combobox {
        display: inline-block;
    }

    .combobox-toggle {
        cursor: pointer;
    }

    .combobox-content {
        display: none;
        position: absolute;
        z-index: 1000;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        left: 0;
        top: 40px;
    }

    .combobox-content::-webkit-scrollbar {
        width: 10px;
    }

    .combobox-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .combobox-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }

    .combobox-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .combobox-item {
        border-bottom: 1px solid #eee;
        padding: 5px;
        text-align: center;
        cursor: pointer;
    }

    .combobox-item:hover {
        background-color: #f5f5f5;
    }

    .report-title {
        display: block;
        margin-top: 1cm;
    }
</style>
@stop

@section('js')
<script>
    function mostrarSelect(tipo, seccion) {
        document.getElementById('form-mensual-transacciones').style.display = 'none';
        document.getElementById('form-anual-transacciones').style.display = 'none';
        document.getElementById('form-global-transacciones').style.display = 'none';

        document.getElementById(`form-${tipo}-${seccion}`).style.display = 'block';
        resetForm(tipo, seccion);
    }

    function mostrarTipoTransaccion(tipo, seccion) {
        const fechaSelect = document.getElementById(`${tipo === 'mensual' ? 'mes' : 'anio'}_transacciones`);
        const tipoTransaccionContainer = document.getElementById(`tipo_transaccion_${tipo}_container`);
        const tipoTransaccion1Container = document.getElementById(`tipo_transaccion1_${tipo}_container`);
        const submitButton = document.getElementById(`submit_${tipo}`);

        if (tipo === 'global' || (fechaSelect && fechaSelect.value !== '')) {
            tipoTransaccionContainer.style.display = 'block';
            tipoTransaccion1Container.style.display = 'none';
            submitButton.style.display = 'none';
        } else {
            resetForm(tipo, seccion);
        }
    }

    function mostrarTipoTransaccion1(tipo, seccion) {
        const tipoTransaccionSelect = document.getElementById(`tipo_transaccion_${tipo}`);
        const tipoTransaccion1Select = document.getElementById(`tipo_transaccion1_${tipo}`);
        const tipoTransaccion1Container = document.getElementById(`tipo_transaccion1_${tipo}_container`);
        const submitButton = document.getElementById(`submit_${tipo}`);

        const selectedTipo = tipoTransaccionSelect.value || '';

        if (selectedTipo === 'TODOS') {
            // Si se selecciona "TODOS" en tipo_transaccion, ocultar tipo_transaccion1 y mostrar el botón directamente
            tipoTransaccion1Container.style.display = 'none';
            submitButton.style.display = 'block';
            // Asegurar que tipo_transaccion1 no interfiera en el formulario
            tipoTransaccion1Select.value = 'TODOS'; // Forzar "TODOS" en tipo_transaccion1 para el backend
        } else if (selectedTipo === 'ingreso' || selectedTipo === 'egreso') {
            // Si es "ingreso" o "egreso", mostrar el select de tipo_transaccion1
            tipoTransaccion1Container.style.display = 'block';
            submitButton.style.display = 'none';
            tipoTransaccion1Select.innerHTML = '<option value="">Seleccione detalle</option>';

            const ingresoOptions = [
                'ahorro inicial',
                'pago ahorro',
                'pago prestamo',
                'multa',
                'precancelacion',

            ];
            const egresoOptions = [
                'retiro interes',
                'retiro ahorro',
                'prestamo'
            ];


            const options = selectedTipo === 'ingreso' ? ingresoOptions : egresoOptions;

            // Agregar "TODOS" como primera opción
            const todosOpt = document.createElement('option');
            todosOpt.value = 'TODOS';
            todosOpt.text = 'TODOS';
            tipoTransaccion1Select.appendChild(todosOpt);

            // Agregar las demás opciones
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option;
                opt.text = option.replace(/_/g, ' ').toUpperCase();
                tipoTransaccion1Select.appendChild(opt);
            });

            // Mostrar el botón "Generar" cuando se selecciona un valor en tipo_transaccion1
            tipoTransaccion1Select.onchange = function() {
                submitButton.style.display = this.value !== '' ? 'block' : 'none';
            };
        } else {
            // Si no hay selección válida, ocultar todo
            tipoTransaccion1Container.style.display = 'none';
            submitButton.style.display = 'none';
        }
    }

    function resetForm(tipo, seccion) {
        const tipoTransaccionContainer = document.getElementById(`tipo_transaccion_${tipo}_container`);
        const tipoTransaccion1Container = document.getElementById(`tipo_transaccion1_${tipo}_container`);
        const submitButton = document.getElementById(`submit_${tipo}`);

        tipoTransaccionContainer.style.display = 'none';
        tipoTransaccion1Container.style.display = 'none';
        submitButton.style.display = 'none';
    }

    // Listener para el formulario global
    document.getElementById('form-global-transacciones').addEventListener('change', function(e) {
        if (e.target.id === 'tipo_transaccion_global') {
            mostrarTipoTransaccion1('global', 'transacciones');
        }
    });
</script>
@stop