<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
    <style>
        @page {
            margin: 170px 50px 80px;
            /* Margen: superior, derecho, inferior, izquierdo */
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

        .receipt-number {
            font-size: 18pt;
            font-weight: bold;
            text-align: letf;
        }

        footer {
            position: fixed;
            bottom: -10px;
            /* Ajusta la posición */
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
        }

        .content {
            text-align: justify;

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
            top: 2;
            left: -37;
            width: 400px;
            /* Ajusta el ancho de la imagen */

            /* Controla la transparencia */
            z-index: -1;
            /* Envía la imagen detrás del contenido */
        }

        .header-container {
            position: relative;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <img class="header-image" src="{{ public_path('img/encabezadoazul1.png') }}" alt="Encabezado">

        <div class="header-container">
            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="text-align: center; font-size: 10pt;">
                        <img src="{{ public_path('storage/' . $configuracion->logo) }}" width="45px" alt="Logo">
                        <p class="company-name">{{ $configuracion->nombre }}</p>
                        {{ $configuracion->descripcion }}<br>
                        {{ $configuracion->direccion }}<br>
                        {{ $configuracion->telefono }}<br>
                        {{ $configuracion->email }}
                    </td>
                    <td width="70%"></td>
                    <td width="50%" style="text-align: letf;">
                        <p class="receipt-number">Préstamo Nº <span>{{ $prestamo->id }}</span></p>
                        Fecha de Emisión: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}<br>
                    </td>
                </tr>
                <tr>hola</tr>
            </table>
        </div>
    </header>

    <footer>
        <img class="footer-image" src="{{ public_path('img/encabezadoazul2.png') }}" alt="Encabezado">

    </footer>

    <main class="content">
        <div class="content">
            <br>
            <b>Datos del cliente:</b>
            <hr>
            <table border="0" class="table" cellpadding="3">
                <tr>
                    <td><b>Documento:</b></td>
                    <td>{{ $prestamo->cliente->nro_documento }}</td>
                    <td style="background-color: #c0c0c0"><b>Correo Electrónico:</b></td>
                    <td>{{ $prestamo->cliente->email }}</td>
                </tr>
                <tr>
                    <td style="background-color: #c0c0c0"><b>Cliente:</b></td>
                    <td>{{ $prestamo->cliente->apellidos }}, {{ $prestamo->cliente->nombres }}</td>
                    <td style="background-color: #c0c0c0"><b>Celular:</b></td>
                    <td>{{ $prestamo->cliente->celular }}</td>
                </tr>
                <tr>
                    <td style="background-color: #c0c0c0"><b>Fecha de Afiliación:</b></td>
                    <td colspan="3">{{ $prestamo->cliente->fecha_afiliacion }}</td>


                </tr>
            </table>
            <br>
            <b>Detalle del prestamo:</b>
            <hr>
            <table border="0" class="table" cellpadding="3">
                <tr>
                    <td style="background-color: #c0c0c0"><b>Monto del prestamo:</b></td>
                    <td>{{ $configuracion->moneda . ' ' . $prestamo->monto_prestado }}</td>
                    <td style="background-color: #c0c0c0"><b>Modalidad Prestamo:</b></td>
                    <td>{{ $prestamo->metodo_prestamo }}</td>
                    <td style="background-color: #c0c0c0"><b>Tasa de Interes:</b></td>
                    <td>{{ $prestamo->tasa_interes_anual }}%</td>

                </tr>
                <tr>
                    <td style="background-color: #c0c0c0"><b>Modalidad de pago:</b></td>
                    <td>{{ $prestamo->modalidad }}</td>
                    <td style="background-color: #c0c0c0"><b>Nro de cuotas:</b></td>
                    <td style="text-align: center">{{ $prestamo->nro_cuotas }}</td>
                    <td style="background-color: #c0c0c0"><b>Estado:</b></td>
                    <td>{{ $prestamo->estado }}</td>
                </tr>

            </table>
            <br>
            <b>Detalle de las cuotas:</b>
            <hr>
            <table border="0" class="table" cellpadding="3">
                <thead>
                    <tr style="background-color: #c0c0c0">
                        <th>Nro de cuotas</th>
                        <th>Fecha de pago</th>
                        <th>Monto de cuota</th>
                        <th>Saldo pendiente</th>
                        <th>Referencia de pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp
                    @foreach ($cuotas as $pago)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td style="text-align: center">{{ $pago->fecha_vencimiento }}</td>
                            <td style="text-align: center">{{ $pago->monto_cuota }}</td>
                            <td style="text-align: center">{{ $pago->saldo_pendiente }}</td>
                            <td style="text-align: center">{{ $pago->referencia_pago }}</td>
                            <td style="text-align: center">{{ $pago->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="background-color: #c0c0c0" colspan="2"><b>Monto total a Pagar:</b></td>
                        <td>{{ $configuracion->moneda . ' ' . $prestamo->monto_total1 }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>

</body>

</html>
