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
        // Obtener parámetros de la solicitud
        $tipoReporte = $request->input('tipo_reporte');
        $tipoTransaccion = $request->input('tipo_transaccion');
        $tipoTransaccion1 = $request->input('tipo_transaccion1');

        // Inicializar variables por defecto
        $totalIngresos = 0;
        $totalEgresos = 0;
        $saldoMensual = 0;
        $transaccionesData = [];
        $tituloReporte = '';

        // Inicializar la consulta base para transacciones
        $transaccionesQuery = Transaccione::query();

        // Aplicar filtros a la consulta
        $this->aplicarFiltros($transaccionesQuery, $tipoTransaccion, $tipoTransaccion1);

        // Preparar datos según el tipo de reporte
        $datosReporte = $this->prepararDatosReporte(
            $transaccionesQuery,
            $tipoReporte,
            $tipoTransaccion,
            $tipoTransaccion1,
            $request,
            $totalIngresos,
            $totalEgresos,
            $saldoMensual,
            $transaccionesData,
            $tituloReporte
        );

        // Extraer los datos preparados
        [
            'totalIngresos' => $totalIngresos,
            'totalEgresos' => $totalEgresos,
            'saldoMensual' => $saldoMensual,
            'transaccionesData' => $transaccionesData,
            'tituloReporte' => $tituloReporte,
        ] = $datosReporte;

        // Obtener las transacciones ordenadas por fecha
        $transacciones = $transaccionesQuery->orderBy('fecha', 'asc')->get();

        // Obtener la configuración más reciente
        $configuracion = Configuracion::latest()->first();

        // Generar y devolver el PDF
        return $this->generarPDF(
            $tituloReporte,
            $configuracion,
            $transacciones,
            $tipoReporte,
            $tipoTransaccion,
            $tipoTransaccion1,
            $transaccionesData,
            $totalIngresos,
            $totalEgresos,
            $saldoMensual
        );
    }

    /**
     * Aplica filtros a la consulta de transacciones según tipo_transaccion y tipo_transaccion1.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $tipoTransaccion
     * @param string|null $tipoTransaccion1
     * @return void
     */
    private function aplicarFiltros($query, $tipoTransaccion, $tipoTransaccion1)
    {
        if ($tipoTransaccion && $tipoTransaccion !== 'TODOS') {
            $query->where('tipo_transaccion', $tipoTransaccion);

            if ($tipoTransaccion1 === 'TODOS') {
                if ($tipoTransaccion === 'ingreso') {
                    $query->whereIn('tipo_transaccion1', ['ahorro inicial', 'pago ahorro', 'pago prestamo', 'multa', 'precancelacion']);
                } elseif ($tipoTransaccion === 'egreso') {
                    $query->whereIn('tipo_transaccion1', ['retiro interes', 'retiro ahorro', 'prestamo']);
                }
            }
        }

        if ($tipoTransaccion1 && $tipoTransaccion1 !== 'TODOS' && $tipoTransaccion !== 'TODOS') {
            $query->where('tipo_transaccion1', $tipoTransaccion1);
        }
    }

    /**
     * Prepara los datos del reporte según el tipo de reporte.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $tipoReporte
     * @param string|null $tipoTransaccion
     * @param string|null $tipoTransaccion1
     * @param \Illuminate\Http\Request $request
     * @param float $totalIngresos
     * @param float $totalEgresos
     * @param float $saldoMensual
     * @param array $transaccionesData
     * @param string $tituloReporte
     * @return array
     */
    private function prepararDatosReporte($query, $tipoReporte, $tipoTransaccion, $tipoTransaccion1, Request $request, float $totalIngresos, float $totalEgresos, float $saldoMensual, array $transaccionesData, string $tituloReporte)
    {
        if ($tipoReporte === 'mensual' && $request->has('mes')) {
            // Preparar datos para reporte mensual
            [$year, $month] = explode('-', $request->input('mes'));
            $query->whereYear('fecha', $year)->whereMonth('fecha', $month);
            $tituloReporte = "Reporte Mensual de Transacciones - " . \Carbon\Carbon::create($year, $month)->translatedFormat('F Y');

            if ($tipoTransaccion === 'TODOS') {
                $transaccionesData = $query->get();
                $totalIngresos = $transaccionesData->where('tipo_transaccion', 'ingreso')->sum('monto');
                $totalEgresos = $transaccionesData->where('tipo_transaccion', 'egreso')->sum('monto');
                $saldoMensual = $totalIngresos - $totalEgresos;
            }
        } elseif ($tipoReporte === 'anual' && $request->has('anio')) {
            // Preparar datos para reporte anual
            $anio = $request->input('anio');
            $query->whereYear('fecha', $anio);
            $tituloReporte = "Reporte Anual de Transacciones - " . $anio;

            $transaccionesData = $query->get()
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->fecha)->month;
                })
                ->map(function ($mesTransacciones) use ($tipoTransaccion, $tipoTransaccion1) {
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
            // Preparar datos para reporte global
            $tituloReporte = "Reporte Global de Transacciones";

            $transaccionesData = $query->get()
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->fecha)->format('Y-m');
                })
                ->map(function ($mesTransacciones) use ($tipoTransaccion, $tipoTransaccion1) {
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
                })
                ->sortKeys(); // Ordenar las claves (Y-m) de más antiguo a más reciente
        }

        return compact(
            'totalIngresos',
            'totalEgresos',
            'saldoMensual',
            'transaccionesData',
            'tituloReporte'
        );
    }

    /**
     * Genera y devuelve el PDF del reporte.
     *
     * @param string $tituloReporte
     * @param \App\Models\Configuracion|null $configuracion
     * @param \Illuminate\Database\Eloquent\Collection $transacciones
     * @param string|null $tipoReporte
     * @param string|null $tipoTransaccion
     * @param string|null $tipoTransaccion1
     * @param array $transaccionesData
     * @param float $totalIngresos
     * @param float $totalEgresos
     * @param float $saldoMensual
     * @return \Illuminate\Http\Response
     */
    private function generarPDF($tituloReporte, $configuracion, $transacciones, $tipoReporte, $tipoTransaccion, $tipoTransaccion1, $transaccionesData, $totalIngresos, $totalEgresos, $saldoMensual)
    {
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
        $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('reporte_transacciones.pdf');
    }
}
