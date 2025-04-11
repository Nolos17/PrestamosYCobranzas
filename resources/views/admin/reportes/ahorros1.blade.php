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
                <td width="15%"></td>
                <td width="50%" style="text-align: left;">
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
        <h3>Resultados</h3>
        @if (empty($datosReporte))
            <p class="no-data">No existen ahorros este período.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        @if ($tipoReporte === 'global')
                            <th>Año</th>
                        @endif
                        @if ($tipoReporte === 'anual' || $tipoReporte === 'global')
                            <th>Mes</th>
                            <th>Nro. Acciones</th>
                            <th>Total Ahorrado</th>
                        @else
                            <th>Nº</th>
                            <th>ID Ahorro</th>
                            <th>Cliente</th>
                            <th>Referencia Pago</th>
                            <th>Nro. Acciones</th>
                            <th>Monto Ahorrado</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($tipoReporte === 'mensual')
                        @foreach ($datosReporte as $item)
                            @foreach ($item['ahorros_pagados'] as $ahorro)
                                <tr>
                                    <td>{{ $loop->parent->iteration }}</td>
                                    <td>{{ $ahorro->id }}</td>
                                    <td>{{ $item['cliente']->nombres . ' ' . $item['cliente']->apellidos }}</td>
                                    <td>{{ $ahorro->referencia_pago ?? 'N/A' }}</td>
                                    <td>{{  $item['cliente']->acciones}}
                                    </td>
                                    <td>{{ number_format($ahorro->monto_ahorro, 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @elseif ($tipoReporte === 'anual')
                        @foreach ($datosReporte as $mes => $datos)
                            @if ($datos['total_ahorrado'] > 0)
                                <!-- Mostrar solo meses con datos -->
                                <tr>
                                    <td>{{ \Carbon\Carbon::create()->month($datos['mes'])->translatedFormat('F') }}
                                    </td>
                                    <td>{{ number_format($datos['nro_acciones'] / ($configuracion->valor_accion ?? 1), 2) }}
                                    </td>
                                    <td>{{ number_format($datos['total_ahorrado'], 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @elseif ($tipoReporte === 'global')
                        @foreach ($datosReporte as $anio => $meses)
                            @foreach ($meses as $mes => $datos)
                                <tr>
                                    <td>{{ $anio }}</td>
                                    <td>{{ \Carbon\Carbon::create()->month($datos['mes'])->translatedFormat('F') }}
                                    </td>
                                    <td>{{ number_format($datos['nro_acciones'] / ($configuracion->valor_accion ?? 1), 2) }}
                                    <td>{{ number_format($datos['total_ahorrado'], 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="{{ $tipoReporte === 'global' ? 2 : ($tipoReporte === 'anual' ? 1 : ($tipoReporte === 'mensual' ? 4 : 5)) }}"
                            style="text-align: right;">Totales:</td>
                        <td>{{ number_format($todosAhorrosPagados->sum('monto_ahorro') / ($configuracion->valor_accion ?? 1), 2) }}
                        </td>
                        <td>{{ number_format($todosAhorrosPagados->sum('monto_ahorro'), 2) }}</td>
                    </tr>

                </tfoot>
            </table>
        @endif
    </div>
</body>

</html>
