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

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .page-container {
            position: relative;
            height: 297mm;
        }

        .receipt-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: calc(50% - 10mm - 1px);
        }

        .receipt-bottom {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: calc(50% - 5mm - 0px);
        }

        .receipt {
            border-bottom: 1px dashed #000;
            padding: 5mm;
            box-sizing: border-box;
        }

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
            text-align: right;
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

        .signature {
            text-align: center;
            margin-top: 5px;
            font-family: 'Dancing Script', cursive;
            font-size: 14pt;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Primer Recibo (Original) en la mitad superior -->
        <div class="receipt receipt-top">
            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="text-align: center; font-size: 10pt;">
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px" alt="Logo">
                        <p class="company-name">{{ $configuracion->nombre }}</p>
                        {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                    </td>
                    <td width="20%"></td>
                    <td width="50%" style="text-align: right;">
                        <p class="receipt-number">Recibo de Retiro Nro {{ $retiro->id }}</p>
                        Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                        <b>Original</b>
                    </td>
                </tr>
            </table>
            <div class="client-info">
                <b>A</b><br>
                <b>{{ $cliente->apellidos }}, {{ $cliente->nombres }}</b><br>
                {{ $cliente->direccion }}
            </div>
            <table border="0" class="table">
                <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA DE RETIRO</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Retiro - {{ $retiro->detalle_retiro }}</td>
                        <td>{{ \Carbon\Carbon::parse($retiro->fecha_retiro)->format('d/m/Y') }}</td>
                        <td>{{ number_format($retiro->total_retiro, 2, '.', '') }}</td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                    <td>{{ number_format($retiro->total_retiro, 2, '.', '') }} {{ $configuracion->moneda }}</td>
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
                            <p>{{ $cliente->apellidos }}, {{ $cliente->nombres }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Segundo Recibo (Copia) en la mitad inferior -->
        <div class="receipt receipt-bottom">
            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="text-align: center; font-size: 10pt;">
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px" alt="Logo">
                        <p class="company-name">{{ $configuracion->nombre }}</p>
                        {{ $configuracion->descripcion }}<br>{{ $configuracion->direccion }}<br>{{ $configuracion->telefono }}<br>{{ $configuracion->email }}
                    </td>
                    <td width="20%"></td>
                    <td width="50%" style="text-align: right;">
                        <p class="receipt-number">Recibo de Retiro Nro {{ $retiro->id }}</p>
                        Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                        <b>Copia</b>
                    </td>
                </tr>
            </table>
            <div class="client-info">
                <b>A</b><br>
                <b>{{ $cliente->apellidos }}, {{ $cliente->nombres }}</b><br>
                {{ $cliente->direccion }}
            </div>
            <table border="0" class="table">
                <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA DE RETIRO</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Retiro - {{ $retiro->detalle_retiro }}</td>
                        <td>{{ \Carbon\Carbon::parse($retiro->fecha_retiro)->format('d/m/Y') }}</td>
                        <td>{{ number_format($retiro->total_retiro, 2, '.', '') }}</td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 12pt;">TOTAL: </td>
                    <td>{{ number_format($retiro->total_retiro, 2, '.', '') }} {{ $configuracion->moneda }}</td>
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
                            <p>{{ $cliente->apellidos }}, {{ $cliente->nombres }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
