<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte PDF - RECIBOS</title>
    <style>
        @page {
            size: A4;
            margin: 0mm;
        }

        .header-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        .footer-image {
            position: absolute;
            top: -80;
            left: 0;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        .footer-image1 {
            position: absolute;
            top: 333;
            left: 0;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        /* Estilos generales para cada recibo */


        /* Para el caso de dos recibos en una sola página, se usa un contenedor de posición relativa */
        .page-container {
            position: relative;
            height: 297mm;
            /* Altura aproximada de A4 */
        }

        /* El recibo superior se posiciona en la parte superior */
        .receipt-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: calc(50% - 10mm - 1px);
        }

        /* El recibo inferior se posiciona exactamente en la mitad */
        .receipt-bottom {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: calc(50% - 5mm - 0px);
        }

        /* Resto de estilos (copiados de tu plantilla original) */
        .company-name {
            font-size: 12pt;
            font-weight: bold;
            color: #4CAF50;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .receipt-number {
            font-size: 18pt;
            font-weight: bold;
            text-align: letf;
        }

        .client-info {
            margin-top: 10px;
            font-size: 10pt;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            padding: 2px;
            text-align: left;
            font-size: 11pt;
        }

        .table th {
            background-color: #f2f2f2;
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

        .totals {
            text-align: right;
            margin-top: 5px;
            font-size: 12pt;
        }

        .signature {
            text-align: center;
            margin-top: 5px;
            font-family: 'Dancing Script', cursive;
            font-size: 14pt;
        }
    </style>


</head>

<body>
    @php
    // Calcular el número total de filas (una sola vez para $cuotas y $ahorro)
    $totalRows = count($transacciones);
    // El valor final de $contador después de los bucles será $totalRows + 1 (porque comienza en 1)
    $contadorFinal = $totalRows + 1;
    // El salto de página ocurre si $contadorFinal >= 8
    $pageBreak = $contadorFinal >= 8;
    @endphp

    @if (!$pageBreak)
    <!-- Ambos recibos en la misma página: el primero en la mitad superior y el segundo en la mitad inferior -->
    <div class="page-container">
        <style>
            .receipt {
                border-bottom: 1px dashed #000;
                padding: 5mm;
                box-sizing: border-box;
            }
        </style>
        <!-- Primer Recibo (Original) en la mitad superior -->
        <div class="receipt receipt-top">
            <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">
            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="text-align: center; font-size: 10pt;">
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px"
                            alt="Logo">
                        <p class="company-name">{{ $configuracion->nombre }}</p>
                        {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                    </td>
                    <td width="20%"></td>
                    <td width="50%" style="text-align: letf;">
                        <p class="receipt-number">Recibo de Pago Nro {{ $pagos->id }}</p>
                        Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                        <b>Original</b>
                    </td>
                </tr>
            </table>
            <div class="client-info">
                <b>A</b><br><b>{{ $pagos->cliente->apellidos }},
                    {{ $pagos->cliente->nombres }}</b><br>{{ $pagos->cliente->direccion }}
            </div>
            <table border="0" class="table">
                <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA DE PAGO</th>
                        <th>IMPORTE</th>

                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp
                    @foreach ($transacciones as $transaccion)
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>{{ $transaccion->detalle }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $transaccion->monto }}</td>
                    </tr>
                    @endforeach

                </tbody>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                    <td>{{ $pagos->total_pago }} {{ $configuracion->moneda }}</td>
                </tr>
            </table>
            <div class="signature">
                <table border="0" width="100%" style="border: none;">
                    <tr>
                        <td style="text-align: center;">
                            <p>Firma del Gerente:</p>
                            <p>__________________________</p>
                            <p>{{ $configuracion->nombre }}</p>
                        </td>
                        <td style="text-align: center;">
                            <p>Firma del Cliente:</p>
                            <p>__________________________</p>
                            <p>{{ $pagos->cliente->apellidos }}, {{ $pagos->cliente->nombres }}</p>
                        </td>
                    </tr>
                </table>
            </div>
            <img class="footer-image1" src="{{ public_path('img/encabezadoazul2.png') }}" alt="Encabezado">
        </div>
        <!-- Segundo Recibo (Copia) en la mitad inferior -->
        <div class="receipt receipt-bottom">
            <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">

            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="text-align: center; font-size: 10pt;">
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px"
                            alt="Logo">
                        <p class="company-name">{{ $configuracion->nombre }}</p>
                        {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                    </td>
                    <td width="20%"></td>
                    <td width="50%" style="text-align: letf;">
                        <p class="receipt-number">Recibo de Pago Nro {{ $pagos->id }}</p>
                        Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                        <b>Copia</b>
                    </td>
                </tr>
            </table>
            <div class="client-info">
                <b>A</b><br><b>{{ $pagos->cliente->apellidos }},
                    {{ $pagos->cliente->nombres }}</b><br>{{ $pagos->cliente->direccion }}
            </div>
            <table border="0" class="table">
                <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA DE PAGO</th>
                        <th>IMPORTE</th>

                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp
                    @foreach ($transacciones as $transaccion)
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>{{ $transaccion->detalle }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $transaccion->monto }}</td>
                    </tr>
                    @endforeach

                </tbody>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                    <td>{{ $pagos->total_pago }} {{ $configuracion->moneda }}</td>
                </tr>
            </table>
            <div class="signature">
                <table border="0" width="100%" style="border: none;">
                    <tr>
                        <td style="text-align: center;">
                            <p>Firma del Gerente:</p>
                            <p>__________________________</p>
                            <p>{{ $configuracion->nombre }}</p>
                        </td>
                        <td style="text-align: center;">
                            <p>Firma del Cliente:</p>
                            <p>__________________________</p>
                            <p>{{ $pagos->cliente->apellidos }}, {{ $pagos->cliente->nombres }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @else
    <style>
        .receipt {
            border: 0px solid #000;
            padding: 5mm;
            box-sizing: border-box;
        }
    </style>
    <!-- Si el primer recibo es largo, forzamos un salto de página para que cada recibo aparezca en su propia página -->
    <div class="receipt">
        <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">

        <!-- Primer Recibo (Original) -->
        <table border="0" width="100%">
            <tr>
                <td width="25%" style="text-align: center; font-size: 10pt;">
                    <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px" alt="Logo">
                    <p class="company-name">{{ $configuracion->nombre }}</p>
                    {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                </td>
                <td width="20%"></td>
                <td width="50%" style="text-align: letf;">
                    <p class="receipt-number">Recibo de Pago Nro {{ $pago->id }}</p>
                    Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                    <b>Original</b>
                </td>
            </tr>
        </table>
        <div class="client-info">
            <b>A</b><br><b>{{ $pago->cliente->apellidos }},
                {{ $pago->cliente->nombres }}</b><br>{{ $pago->cliente->direccion }}
        </div>
        <table border="0" class="table">
            <thead>
                <tr>
                    <th>CANT.</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FECHA DE PAGO</th>
                    <th>IMPORTE</th>
                    <th>MULTA</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach ($cuotas as $cuota)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>Préstamo - {{ $cuota->referencia_pago }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuota->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $cuota->monto_cuota }}</td>
                    <td>{{ $cuota->multa }}</td>
                    <td>{{ number_format($cuota->monto_cuota + $cuota->multa, 2, '.', '') }}
                </tr>
                @endforeach
                @foreach ($ahorro as $ahorro_item)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>Ahorro - {{ $ahorro_item->referencia_pago }}</td>
                    <td>{{ \Carbon\Carbon::parse($ahorro_item->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $ahorro_item->monto_ahorro }}</td>
                    <td>{{ $ahorro_item->multa }}</td>
                    <td>{{ number_format($ahorro_item->monto_ahorro + $ahorro_item->multa, 2, '.', '') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                <td>{{ $pago->total_pago }} {{ $configuracion->moneda }}</td>
            </tr>
        </table>
        <div class="signature">
            <table border="0" width="100%" style="border: none;">
                <tr>
                    <td style="text-align: center;">
                        <p>Firma del Gerente:</p>
                        <p>__________________________</p>
                        <p>{{ $configuracion->nombre }}</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Firma del Cliente:</p>
                        <p>__________________________</p>
                        <p>{{ $pago->cliente->apellidos }}, {{ $pago->cliente->nombres }}</p>
                    </td>
                </tr>
            </table>
        </div>
        <footer> <img class="footer-image" src="{{ public_path('img/encabezadoazul2.png') }}" alt="Encabezado">
        </footer>

    </div>

    <div class="receipt" style="page-break-before: always;">
        <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">

        <!-- Segundo Recibo (Copia) -->
        <table border="0" width="100%">
            <tr>
                <td width="25%" style="text-align: center; font-size: 10pt;">
                    <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px"
                        alt="Logo">
                    <p class="company-name">{{ $configuracion->nombre }}</p>
                    {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                </td>
                <td width="20%"></td>
                <td width="50%" style="text-align: letf;">
                    <p class="receipt-number">Recibo de Pago Nro {{ $pago->id }}</p>
                    Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                    <b>Copia</b>
                </td>
            </tr>
        </table>
        <div class="client-info">
            <b>A</b><br><b>{{ $pago->cliente->apellidos }},
                {{ $pago->cliente->nombres }}</b><br>{{ $pago->cliente->direccion }}
        </div>
        <table border="0" class="table">
            <thead>
                <tr>
                    <th>CANT.</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FECHA DE PAGO</th>
                    <th>IMPORTE</th>
                    <th>MULTA</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach ($cuotas as $cuota)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>Préstamo - {{ $cuota->referencia_pago }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuota->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $cuota->monto_cuota }}</td>
                    <td>{{ $cuota->multa }}</td>
                    <td>{{ number_format($cuota->monto_cuota + $cuota->multa, 2, '.', '') }}
                </tr>
                @endforeach
                @foreach ($ahorro as $ahorro_item)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>Ahorro - {{ $ahorro_item->referencia_pago }}</td>
                    <td>{{ \Carbon\Carbon::parse($ahorro_item->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $ahorro_item->monto_ahorro }}</td>
                    <td>{{ $ahorro_item->multa }}</td>
                    <td>{{ number_format($ahorro_item->monto_ahorro + $ahorro_item->multa, 2, '.', '') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                <td>{{ $pago->total_pago }} {{ $configuracion->moneda }}</td>
            </tr>
        </table>
        <div class="signature">
            <table border="0" width="100%" style="border: none;">
                <tr>
                    <td style="text-align: center;">
                        <p>Firma del Gerente:</p>
                        <p>__________________________</p>
                        <p>{{ $configuracion->nombre }}</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Firma del Cliente:</p>
                        <p>__________________________</p>
                        <p>{{ $pago->cliente->apellidos }}, {{ $pago->cliente->nombres }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    <footer>
        <img class="footer-image" src="{{ public_path('img/encabezadoazul2.png') }}" alt="Encabezado">
    </footer>
</body>



</html>