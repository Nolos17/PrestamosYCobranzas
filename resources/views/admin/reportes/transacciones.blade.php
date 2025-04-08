<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $tituloReporte }}</title>
    <style>
        @page {
            margin: 170px 50px 80px;
        }


        header {
            position: fixed;
            top: -150px;
            /* Ajusta para que aparezca en todas las páginas */
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
            margin: 0;
            padding: 0;
            font-size: 9pt;
        }

        .company-name {
            font-size: 12pt;
            font-weight: bold;
            color: #113db6;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        body::before {
            content: "";
            position: fixed;
            top: 50%;
            left: 50%;
            width: 60%;
            height: 60%;
            background: url('{{ public_path('storage/' . $configuracion->logo) }}') no-repeat center;
            background-size: contain;
            opacity: 0.1;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
        }


        /* Diseño de las tablas (corregido para bordes completos) */
        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            /* Borde externo de la tabla */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            /* Bordes completos para todas las celdas */
            padding: 3px;
            font-size: 11pt;
            text-align: left;
        }

        .table th {
            background-color: #c0c0c0;
            font-weight: bold;
        }

        .table tfoot td {
            font-weight: bold;
            background-color: #f0f0f0;
        }



        .header-image {
            position: absolute;
            top: -15;
            right: -37;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        .footer-image {
            position: absolute;
            top: -28;
            left: -37;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        .no-data {
            text-align: center;
            font-size: 16pt;
            color: #666;
            position: absolute;
            top: calc(50% - 3cm);
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">
        <table border="0" width="100%">
            <tr>
                <td width="25%" style="text-align: center; font-size: 10pt;">
                    @if ($configuracion && $configuracion->logo)
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px" alt="Logo">
                    @endif
                    <p class="company-name">{{ $configuracion->nombre ?? 'Nombre de la Empresa' }}</p>
                    {{ $configuracion->descripcion ?? '' }}<br>
                    {{ $configuracion->direccion ?? '' }}<br>
                    {{ $configuracion->telefono ?? '' }}<br>
                    {{ $configuracion->email ?? '' }}
                </td>
                <td width="10%"></td>
                <td width="50%" style="text-align: letf ;">
                    <h1>{{ $tituloReporte }}</h1>
                    Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [del] YYYY') }}<br>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <img class="footer-image" src="{{ public_path('img/encabezadoazul2.png') }}" alt="Encabezado">
    </footer>

    <div class="content">
        <h2>Resultados</h2>
        @if ($transacciones->isEmpty() && empty($transaccionesData))
            <p class="no-data">No existen transacciones para este período.</p>
        @else
            @if ($tipoReporte === 'mensual')
                @if ($tipoTransaccion === 'TODOS')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Tipo Transacción</th>
                                <th>Detalle Transacción</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $contador = 1; @endphp
                            @foreach ($transacciones as $transaccion)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ ucfirst($transaccion->tipo_transaccion) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $transaccion->tipo_transaccion1)) }}</td>
                                    <td>{{ $transaccion->detalle }}</td>
                                    <td>{{ number_format($transaccion->monto, 2) }}</td>
                                    <td>{{ number_format($transaccion->saldo, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Ingresos:</td>
                                <td>{{ number_format($totalIngresos ?? 0, 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Egresos:</td>
                                <td>{{ number_format($totalEgresos ?? 0, 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">Saldo (Ingresos - Egresos):</td>
                                <td>{{ number_format($saldoMensual ?? 0, 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Tipo Transacción</th>
                                <th>Detalle Transacción</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $contador = 1; @endphp
                            @foreach ($transacciones as $transaccion)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ ucfirst($transaccion->tipo_transaccion) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $transaccion->tipo_transaccion1)) }}</td>
                                    <td>{{ $transaccion->detalle }}</td>
                                    <td>{{ number_format($transaccion->monto, 2) }}</td>
                                    <td>{{ number_format($transaccion->saldo, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total:</td>
                                <td>{{ number_format($transacciones->sum('monto'), 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            @elseif ($tipoReporte === 'anual')
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            @if ($tipoTransaccion === 'TODOS')
                                <th>Tipo Transacción</th>
                                <th>Detalle Transacción</th>
                                <th>Total</th>
                            @else
                                <th>Total {{ ucfirst($tipoTransaccion) }}
                                    ({{ ucfirst(str_replace('_', ' ', $tipoTransaccion1)) }})</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (range(1, 12) as $mes)
                            @if (isset($transaccionesData[$mes]))
                                @if ($tipoTransaccion === 'TODOS')
                                    @foreach ($transaccionesData[$mes]['ingresos'] ?? [] as $tipo => $total)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }}</td>
                                            <td>Ingreso</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($transaccionesData[$mes]['egresos'] ?? [] as $tipo => $total)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }}</td>
                                            <td>Egreso</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>{{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }}
                                                - Total</strong></td>
                                        <td colspan="2" style="text-align: right;">Saldo:</td>
                                        <td><strong>{{ number_format($transaccionesData[$mes]['saldo'], 2) }}</strong>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }}</td>
                                        <td>{{ number_format($transaccionesData[$mes]['total'], 2) }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                    @if ($tipoTransaccion === 'TODOS')
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total Ingresos:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'ingreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total Egresos:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'egreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Saldo Anual:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'ingreso')->sum('monto') - $transacciones->where('tipo_transaccion', 'egreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            @elseif ($tipoReporte === 'global')
                <table class="table">
                    <thead>
                        <tr>
                            <th>Año-Mes</th>
                            @if ($tipoTransaccion === 'TODOS')
                                <th>Tipo Transacción</th>
                                <th>Detalle Transacción</th>
                                <th>Total</th>
                            @else
                                <th>Total {{ ucfirst($tipoTransaccion) }}
                                    ({{ ucfirst(str_replace('_', ' ', $tipoTransaccion1)) }})</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaccionesData as $anioMes => $data)
                            @if ($tipoTransaccion === 'TODOS')
                                @foreach ($data['ingresos'] ?? [] as $tipo => $total)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $anioMes)->translatedFormat('F Y') }}
                                        </td>
                                        <td>Ingreso</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</td>
                                        <td>{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($data['egresos'] ?? [] as $tipo => $total)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $anioMes)->translatedFormat('F Y') }}
                                        </td>
                                        <td>Egreso</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</td>
                                        <td>{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $anioMes)->translatedFormat('F Y') }}
                                            - Total</strong></td>
                                    <td colspan="2" style="text-align: right;">Saldo:</td>
                                    <td><strong>{{ number_format($data['saldo'], 2) }}</strong></td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $anioMes)->translatedFormat('F Y') }}
                                    </td>
                                    <td>{{ number_format($data['total'], 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    @if ($tipoTransaccion === 'TODOS')
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total Ingresos:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'ingreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total Egresos:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'egreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Saldo Global:</td>
                                <td>{{ number_format($transacciones->where('tipo_transaccion', 'ingreso')->sum('monto') - $transacciones->where('tipo_transaccion', 'egreso')->sum('monto'), 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            @endif
        @endif
    </div>
</body>

</html>
