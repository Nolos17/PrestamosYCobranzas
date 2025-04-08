<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Prestamo;
use App\Models\Cuota;
use App\Models\Ahorro;
use App\Models\Cliente;
use App\Models\Transaccione;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    public function index()
    {
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        $anioActual = Carbon::now()->year;
        $total_prestamos = Prestamo::count(); // Total de préstamos como ejemplo
        $total_ahorros = Ahorro::count();     // Total de ahorros como ejemplo
        $total_transacciones = Transaccione::count();     // Total de ahorros como ejemplo

        return view('admin.reportes.index', compact('meses', 'anioActual', 'total_prestamos', 'total_ahorros', 'total_transacciones'));
    }

    public function prestamos1(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $tipoReporte = $request->input('tipo_reporte');
        $mesMensual = $request->input('mes'); // Ejemplo: "2025-04"

        if ($tipoReporte === 'mensual') {
            // Convertir mes_mensual en rango de fechas
            $inicioMes = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual)->startOfMonth();
            $finMes = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual)->endOfMonth();

            // Utilizar para cambiar el cliterio de filtrado por fecha de inicio prestamo
            //$prestamos = Prestamo::whereBetween('fecha_inicio', [$inicioMes, $finMes])->get();

            // Buscamos los pagos de los prestamos pagados en cierto tiempo.

            $prestamos = Prestamo::whereHas('cuotas', function ($query) use ($inicioMes, $finMes) {
                $query->where('estado', 'Pagado')
                    ->whereBetween('fecha_pago', [$inicioMes, $finMes]);
            })->get();
            $datosReporte = [];

            $datosReporte = [];
            // Colección plana de todas las cuotas pagadas
            $todasCuotasPagadas = collect();

            foreach ($prestamos as $prestamo) {
                // Obtener las cuotas pagadas de este préstamo
                // Obtener solo las cuotas pagadas en el mes seleccionado
                $cuotasPagadas = Cuota::where('prestamo_id', $prestamo->id)
                    ->where('estado', 'Pagado')
                    ->whereBetween('fecha_pago', [$inicioMes, $finMes])
                    ->get();

                // Agregar las cuotas a la colección plana
                $todasCuotasPagadas = $todasCuotasPagadas->merge($cuotasPagadas);

                // Preparar datos para cada préstamo
                $datosReporte[] = [
                    'prestamo' => $prestamo,
                    'cuotas_pagadas' => $cuotasPagadas
                ];
            }

            // Convertir mes_mensual a nombre del mes y año (ejemplo: "Abril 2025")
            $fecha = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual);
            $tituloReporte = "Reporte Mensual de Préstamos - " . $fecha->translatedFormat('F Y');

            // Enviar datos al PDF, incluyendo la colección de cuotas pagadas
            $pdf = PDF::loadView('admin.reportes.prestamos1', compact('datosReporte', 'tituloReporte', 'todasCuotasPagadas'));

            $pdf->setPaper('A4', 'portrait');
            // Generar el PDF
            $pdf->render(); // Esto es necesario para obtener la cantidad total de páginas

            // Obtener el canvas (el lienzo sobre el que se renderiza el PDF)
            $canvas = $pdf->getCanvas();

            // Agregar la numeración de páginas en el pie de página
            $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream();
        }

        return response()->json(['error' => 'Tipo de reporte no soportado'], 400);
    }
    public function prestamos2(Request $request)
    {
        // $datos = request()->all();
        //return response()->json($datos);
        $tipoReporte = $request->input('tipo_reporte');
        $anio = $request->input('anio'); // Año seleccionado para el reporte anual

        if ($tipoReporte === 'anual') {
            // Reporte anual
            $datosReporte = [];
            $totales = [
                'capital' => 0,
                'interes' => 0,
                'total' => 0,
            ];

            // Iterar sobre los 12 meses del año seleccionado
            for ($mes = 1; $mes <= 12; $mes++) {
                $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT); // Formato '01', '02', etc.
                $inicioMes = \Carbon\Carbon::create($anio, $mes, 1)->startOfMonth();
                $finMes = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();

                // Obtener cuotas pagadas en este mes y año
                $cuotasPagadas = Cuota::where('estado', 'Pagado')
                    ->whereBetween('fecha_pago', [$inicioMes, $finMes])
                    ->get();

                $capital = $cuotasPagadas->sum('capital');
                $interes = $cuotasPagadas->sum('interes');
                $total = $cuotasPagadas->sum('monto_cuota');

                // Almacenar datos por mes
                $datosReporte[$mesStr] = [
                    'capital' => $capital,
                    'interes' => $interes,
                    'total' => $total,
                ];

                // Sumar a los totales generales
                $totales['capital'] += $capital;
                $totales['interes'] += $interes;
                $totales['total'] += $total;
            }

            $tituloReporte = "Reporte Anual de Préstamos - $anio";

            $pdf = PDF::loadView('admin.reportes.prestamos2', compact('datosReporte', 'totales', 'tituloReporte', 'tipoReporte', 'anio'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $canvas = $pdf->getCanvas();
            // Agregar la numeración de páginas en el pie de página
            $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream();
        } elseif ($tipoReporte === 'global') {
            // Reporte global
            $cuotasPagadas = Cuota::where('estado', 'Pagado')->get();
            $datosReporte = [];
            $totales = [
                'capital' => 0,
                'interes' => 0,
                'total' => 0,
            ];

            // Agrupar cuotas por año y mes
            foreach ($cuotasPagadas as $cuota) {
                $fecha = \Carbon\Carbon::parse($cuota->fecha_pago);
                $anioCuota = $fecha->year;
                $mes = $fecha->format('m');

                if (!isset($datosReporte[$anioCuota])) {
                    $datosReporte[$anioCuota] = [];
                }
                if (!isset($datosReporte[$anioCuota][$mes])) {
                    $datosReporte[$anioCuota][$mes] = [
                        'capital' => 0,
                        'interes' => 0,
                        'total' => 0,
                    ];
                }

                $datosReporte[$anioCuota][$mes]['capital'] += $cuota->capital;
                $datosReporte[$anioCuota][$mes]['interes'] += $cuota->interes;
                $datosReporte[$anioCuota][$mes]['total'] += $cuota->monto_cuota;

                $totales['capital'] += $cuota->capital;
                $totales['interes'] += $cuota->interes;
                $totales['total'] += $cuota->monto_cuota;
            }

            $tituloReporte = "Reporte Global de Préstamos";

            $pdf = PDF::loadView('admin.reportes.prestamos2', compact('datosReporte', 'totales', 'tituloReporte', 'tipoReporte'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $canvas = $pdf->getCanvas();
            $canvas->page_text(270, 770, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12, [0, 0, 0]);
            return $pdf->stream();
        }

        return response()->json(['error' => 'Tipo de reporte no soportado'], 400);
    }

    public function ahorros1(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte');
        $mesMensual = $request->input('mes'); // Ejemplo: "2025-04" (para mensual)
        $anio = $request->input('anio'); // Año seleccionado (para anual)

        $datosReporte = [];
        $todosAhorrosPagados = collect();
        $tituloReporte = '';

        if ($tipoReporte === 'mensual') {
            $inicioMes = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual)->startOfMonth();
            $finMes = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual)->endOfMonth();

            $clientes = Cliente::whereHas('ahorros', function ($query) use ($inicioMes, $finMes) {
                $query->where('estado', 'Pagado')
                    ->whereBetween('fecha_pago', [$inicioMes, $finMes]);
            })->get();

            foreach ($clientes as $cliente) {
                $ahorrosPagados = Ahorro::where('cliente_id', $cliente->id)
                    ->where('estado', 'Pagado')
                    ->whereBetween('fecha_pago', [$inicioMes, $finMes])
                    ->get();

                if ($ahorrosPagados->isNotEmpty()) {
                    $todosAhorrosPagados = $todosAhorrosPagados->merge($ahorrosPagados);
                    $datosReporte[] = [
                        'cliente' => $cliente,
                        'ahorros_pagados' => $ahorrosPagados,
                    ];
                }
            }

            $fecha = \Carbon\Carbon::createFromFormat('Y-m', $mesMensual);
            $tituloReporte = "Reporte Mensual de Ahorros - " . $fecha->translatedFormat('F Y');
        } elseif ($tipoReporte === 'anual') {
            $inicioAnio = \Carbon\Carbon::create($anio, 1, 1)->startOfYear();
            $finAnio = \Carbon\Carbon::create($anio, 12, 31)->endOfYear();

            $ahorros = Ahorro::where('estado', 'Pagado')
                ->whereBetween('fecha_pago', [$inicioAnio, $finAnio])
                ->get();

            // Agrupar ahorros por mes
            $datosReporte = [];
            for ($mes = 1; $mes <= 12; $mes++) {
                $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
                $ahorrosMes = $ahorros->filter(function ($ahorro) use ($mes) {
                    return \Carbon\Carbon::parse($ahorro->fecha_pago)->month == $mes;
                });

                $datosReporte[$mesStr] = [
                    'mes' => $mes,
                    'total_ahorrado' => $ahorrosMes->sum('monto_ahorro'),
                    'nro_acciones' => $ahorrosMes->sum('monto_ahorro') / ($request->configuracion->valor_accion ?? 1),
                ];
                $todosAhorrosPagados = $todosAhorrosPagados->merge($ahorrosMes);
            }

            $tituloReporte = "Reporte Anual de Ahorros - $anio";
        } elseif ($tipoReporte === 'global') {
            $ahorros = Ahorro::where('estado', 'Pagado')->get();

            // Agrupar ahorros por año y mes
            $datosReporte = [];
            foreach ($ahorros as $ahorro) {
                $fecha = \Carbon\Carbon::parse($ahorro->fecha_pago);
                $anioAhorro = $fecha->year;
                $mes = str_pad($fecha->month, 2, '0', STR_PAD_LEFT);

                if (!isset($datosReporte[$anioAhorro])) {
                    $datosReporte[$anioAhorro] = [];
                }
                if (!isset($datosReporte[$anioAhorro][$mes])) {
                    $datosReporte[$anioAhorro][$mes] = [
                        'mes' => $fecha->month,
                        'total_ahorrado' => 0,
                        'nro_acciones' => 0,
                    ];
                }

                $datosReporte[$anioAhorro][$mes]['total_ahorrado'] += $ahorro->monto_ahorro;
                $datosReporte[$anioAhorro][$mes]['nro_acciones'] += $ahorro->monto_ahorro / ($request->configuracion->valor_accion ?? 1);
                $todosAhorrosPagados = $todosAhorrosPagados->merge([$ahorro]);
            }

            // Ordenar por año y mes
            ksort($datosReporte);
            foreach ($datosReporte as &$meses) {
                ksort($meses);
            }

            $tituloReporte = "Reporte Global de Ahorros";
        } else {
            return response()->json(['error' => 'Tipo de reporte no soportado'], 400);
        }

        $pdf = PDF::loadView('admin.reportes.ahorros1', compact('datosReporte', 'tituloReporte', 'todosAhorrosPagados', 'tipoReporte'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $canvas = $pdf->getCanvas();
        // Agregar la numeración de páginas en el pie de página
        $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream();
    }

    public function transacciones1(Request $request)
    {

        //$datos = Request()->all();
        //return Response()->json($datos);
        $tipoReporte = $request->input('tipo_reporte');
        $mesMensual = $request->input('mes'); // Ejemplo: "2025-04" (para mensual)
        $anio = $request->input('anio'); // Año seleccionado (para anual)
        $tipo_transaccion = $request->input('tipo_transaccion'); // Año seleccionado (para anual)
        $tipo_transaccion1 = $request->input('tipo_transaccion1'); // Año seleccionado (para anual)


    }

    public function transacciones(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte');
        $tipoTransaccion = $request->input('tipo_transaccion');
        $tipoTransaccion1 = $request->input('tipo_transaccion1');

        $transacciones = Transaccione::query();

        // Variables por defecto para evitar errores de undefined
        $totalIngresos = 0;
        $totalEgresos = 0;
        $saldoMensual = 0;
        $transaccionesData = [];

        // Filtros básicos
        if ($tipoTransaccion && $tipoTransaccion !== 'TODOS') {
            $transacciones->where('tipo_transaccion', $tipoTransaccion);
            if ($tipoTransaccion1 === 'TODOS') {
                if ($tipoTransaccion === 'ingreso') {
                    $transacciones->whereIn('tipo_transaccion1', ['ahorro inicial', 'pago ahorro', 'pago prestamo', 'multa', 'precancelacion']);
                } elseif ($tipoTransaccion === 'egreso') {
                    $transacciones->whereIn('tipo_transaccion1', ['retiro interes', 'retiro ahorro', 'prestamo']);
                }
            }
        }

        if ($tipoTransaccion1 && $tipoTransaccion1 !== 'TODOS' && $tipoTransaccion !== 'TODOS') {
            $transacciones->where('tipo_transaccion1', $tipoTransaccion1);
        }

        // Filtros temporales y preparación de datos
        if ($tipoReporte === 'mensual' && $request->has('mes')) {
            [$year, $month] = explode('-', $request->input('mes'));
            $transacciones->whereYear('fecha', $year)->whereMonth('fecha', $month);
            $tituloReporte = "Reporte Mensual de Transacciones - " . \Carbon\Carbon::create($year, $month)->translatedFormat('F Y');

            // Si es "TODOS", calcular ingresos y egresos
            if ($tipoTransaccion === 'TODOS') {
                $transaccionesData = $transacciones->get();
                $totalIngresos = $transaccionesData->where('tipo_transaccion', 'ingreso')->sum('monto');
                $totalEgresos = $transaccionesData->where('tipo_transaccion', 'egreso')->sum('monto');
                $saldoMensual = $totalIngresos - $totalEgresos;
            }
        } elseif ($tipoReporte === 'anual' && $request->has('anio')) {
            $anio = $request->input('anio');
            $transacciones->whereYear('fecha', $anio);
            $tituloReporte = "Reporte Anual de Transacciones - " . $anio;

            // Agrupar por mes y tipo para el reporte anual
            $transaccionesData = $transacciones->get()->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->fecha)->month;
            })->map(function ($mesTransacciones) use ($tipoTransaccion, $tipoTransaccion1) {
                if ($tipoTransaccion === 'TODOS') {
                    return [
                        'ingresos' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->groupBy('tipo_transaccion1')->map->sum('monto'),
                        'egresos' => $mesTransacciones->where('tipo_transaccion', 'egreso')->groupBy('tipo_transaccion1')->map->sum('monto'),
                        'total_ingresos' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->sum('monto'),
                        'total_egresos' => $mesTransacciones->where('tipo_transaccion', 'egreso')->sum('monto'),
                        'saldo' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->sum('monto') - $mesTransacciones->where('tipo_transaccion', 'egreso')->sum('monto')
                    ];
                } else {
                    return [
                        'total' => $mesTransacciones->sum('monto')
                    ];
                }
            });
        } else {
            $tituloReporte = "Reporte Global de Transacciones";

            // Agrupar por año y mes para el reporte global
            $transaccionesData = $transacciones->get()->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->fecha)->format('Y-m');
            })->map(function ($mesTransacciones) use ($tipoTransaccion, $tipoTransaccion1) {
                if ($tipoTransaccion === 'TODOS') {
                    return [
                        'ingresos' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->groupBy('tipo_transaccion1')->map->sum('monto'),
                        'egresos' => $mesTransacciones->where('tipo_transaccion', 'egreso')->groupBy('tipo_transaccion1')->map->sum('monto'),
                        'total_ingresos' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->sum('monto'),
                        'total_egresos' => $mesTransacciones->where('tipo_transaccion', 'egreso')->sum('monto'),
                        'saldo' => $mesTransacciones->where('tipo_transaccion', 'ingreso')->sum('monto') - $mesTransacciones->where('tipo_transaccion', 'egreso')->sum('monto')
                    ];
                } else {
                    return [
                        'total' => $mesTransacciones->sum('monto')
                    ];
                }
            });
        }

        $transacciones = $transacciones->orderBy('fecha', 'asc')->get();
        $configuracion = Configuracion::latest()->first();

        // Pasar todas las variables a la vista, incluso si no se usan en todos los casos
        $pdf = PDF::loadView('admin.reportes.transacciones', compact(
            'tituloReporte',
            'configuracion',
            'transacciones',
            'tipoReporte',
            'tipoTransaccion',
            'tipoTransaccion1',
            'transaccionesData',
            'totalIngresos',
            'totalEgresos',
            'saldoMensual'
        ));
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $canvas = $pdf->getCanvas();
        // Agregar la numeración de páginas en el pie de página
        $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('reporte_transacciones.pdf');
    }
}
