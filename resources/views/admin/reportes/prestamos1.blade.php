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
            background: url('{{ public_path(' storage/' . $configuracion->logo) }}') no-repeat center;
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
                <td width="50%" style="text-align: letf;">
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
        <p class="no-data">No existen préstamos este mes.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nº</th>

                    <th>Nº Prestamo</th>
                    <th>Cliente</th>
                    <th>Tasa de Interés</th>
                    <th>Modalidad</th>
                    <th>Capital Recaudado</th>
                    <th>Interés Recaudado</th>
                    <th>Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosReporte as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['prestamo']->id }}</td>
                    <td>{{ $item['prestamo']->cliente ? $item['prestamo']->cliente->nombres . ' ' . $item['prestamo']->cliente->apellidos : 'N/A' }}
                    </td>
                    <td>{{ $item['prestamo']->tasa_interes_anual }}%</td>
                    <td>{{ $item['prestamo']->modalidad }}</td>
                    <td>{{ $item['cuotas_pagadas']->sum('capital') }}</td>
                    <td>{{ $item['cuotas_pagadas']->sum('interes') }}</td>
                    <td>{{ $item['cuotas_pagadas']->sum('capital') + $item['cuotas_pagadas']->sum('interes') }}</td>





                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Totales:</td>
                    <td>{{ $todasCuotasPagadas->sum('capital') }}</td>
                    <td>{{ $todasCuotasPagadas->sum('interes') }}</td>
                    <td>{{ $todasCuotasPagadas->sum('capital')+$todasCuotasPagadas->sum('interes') }}</td>

                </tr>
            </tfoot>

            @endif
    </div>
</body>

</html>