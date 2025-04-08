<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Ahorro;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\Retiro;
use App\Models\Transaccione;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $pago = Pago::all();
        return view('admin.cuotas.index', compact('pago'));
    }

    public function interes()
    {
        $clientes = Cliente::whereDoesntHave('ahorros', function ($query) {
            $query->where('estado', '!=', 'Pagado');
        })->get();
        $configuracion = Configuracion::latest()->first();
        return view('admin.cuotas.interes', compact('clientes', 'configuracion'));
    }

    public function pagarinteres($id)
    {

        $cliente = Cliente::findOrFail($id);
        $ahorros = Ahorro::where('cliente_id', $cliente->id)->get();
        $cuotas = Cuota::whereHas('prestamo', function ($query) use ($cliente) {
            $query->where('cliente_id', $cliente->id);
        })->get();
        $pagos = Pago::where('cliente_id', $cliente->id)->get();
        return view('admin.cuotas.pagarinteres', compact('cuotas', 'ahorros', 'pagos', 'cliente'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();

        return view('admin.cuotas.create', compact('clientes'));
    }

    /**
     * Obtiene los datos de un cliente mediante AJAX.
     */
    public function obtenerCliente($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function getPrestamosCliente($id)
    {
        $prestamos = Prestamo::where('cliente_id', $id)
            ->where('estado', 'Activo') // Ajusta según tu lógica de negocio
            ->get()
            ->map(function ($prestamo) {
                return [
                    'id' => $prestamo->id,
                    'monto_total' => $prestamo->monto_total,
                    'fecha_inicio' => $prestamo->fecha_inicio,
                ];
            });

        return response()->json($prestamos);
    }

    /**
     * Obtiene las cuotas pendientes de un cliente (préstamos) mediante AJAX.
     */
    public function getPagosPendientes($id)
    {
        $prestamos = Prestamo::where('cliente_id', $id)->get();

        if ($prestamos->isEmpty()) {
            return response()->json([]);
        }

        $cuotas = Cuota::whereIn('prestamo_id', $prestamos->pluck('id'))
            ->where('estado', 'Pendiente')
            ->get()
            ->map(function ($cuota) {
                return [
                    'id' => $cuota->id,
                    'id_compuesto' => 'prestamo_' . $cuota->id, // ID especial
                    'prestamo_id' => $cuota->prestamo->id ?? 'N/A',
                    'transaccion' => 'Préstamo',
                    'detalle' => $cuota->referencia_pago ?? 'Cuota ' . $cuota->id,
                    'monto' => $cuota->monto_cuota,
                    'interes' => $cuota->interes,
                    'capital' => $cuota->capital,
                    'fecha_vencimiento' => $cuota->fecha_vencimiento,
                ];
            });

        return response()->json($cuotas);
    }

    public function getAhorrosPendientes($id)
    {
        $ahorros = Ahorro::where('cliente_id', $id)
            ->where('estado', 'Pendiente')
            ->get();

        if ($ahorros->isEmpty()) {
            return response()->json([]);
        }

        $ahorrosPendientes = $ahorros->map(function ($ahorro) {
            return [
                'id' => $ahorro->id,
                'id_compuesto' => 'ahorro_' . $ahorro->id, // ID especial
                'transaccion' => 'Ahorro',
                'detalle' => $ahorro->referencia_pago,
                'monto' => $ahorro->monto_ahorro,
                'fecha_vencimiento' => $ahorro->fecha_vencimiento ?? null,
            ];
        });

        return response()->json($ahorrosPendientes);
    }

    public function store1(Request $request)
    {
        $configuracion = Configuracion::latest()->first();
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'saldo_ahorro1' => 'required',
            'saldo_ahorro' => 'required',
            'tasa_interes_anual' => 'required',
            'interes_generado' => 'required',


            //fecha generar automiticamente
            //metodo retiro automaticamente
            //detalle retiro coloco el interes con un mensaje

        ]);


        if ($request->action === 'pagar') {
            // Lógica para pagar
            //Generar el retiro
            $retiro = new Retiro();
            $retiro->cliente_id = $request->cliente_id;
            $retiro->total_retiro = $request->interes_generado;
            $retiro->metodo_retiro = 'Efectivo';
            $retiro->fecha_retiro = Carbon::now();
            $retiro->detalle_retiro = $request->tasa_interes_anual . ' Interes generado por ahorro';
            $retiro->save();

            // Obtener el cliente
            $cliente = Cliente::findOrFail($request->cliente_id);
            $cliente->saldo_ahorro1 = $request->saldo_ahorro;
            $cliente->saldo_ahorro = $request->saldo_ahorro;
            $cliente->save();

            // Obtener el último saldo registrado para las transacciones
            $ultimaTransaccion = Transaccione::latest('id')->first();
            $saldoAnterior = $ultimaTransaccion ? $ultimaTransaccion->saldo : 0;

            // Registrar la transacción (egreso por retiro de interés)
            $transaccion = new Transaccione();
            $transaccion->tipo_transaccion = 'egreso';
            $transaccion->tipo_transaccion1 = 'retiro interes';
            $transaccion->detalle = 'Retiro de Interes generado por ahorro del cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
            $transaccion->retiro_id = $retiro->id;
            $transaccion->monto = $request->interes_generado;
            $saldoAnterior -= $request->interes_generado;
            $transaccion->saldo = $saldoAnterior;
            $transaccion->fecha = Carbon::now();
            $transaccion->save();

            //creacion plan de ahorro
            $resultado = $this->crearPlanAhorro($request, $cliente);

            // Verificar el resultado del plan de ahorro
            if ($resultado !== true) {
                return $resultado; // Esto será la redirección con error si falla
            }
        } elseif ($request->action === 'ahorrar') {
            $pago = new Pago();
            $pago->cliente_id = $request->cliente_id;
            $pago->total_pago = $request->interes_generado;
            $pago->metodo_pago = 'Movimiento interno';
            $pago->fecha_pago = Carbon::now();
            $pago->detalle_pago = 'Pago por Interes generado ';
            $pago->save();

            // Obtener el cliente
            $cliente = Cliente::findOrFail($request->cliente_id);
            $cliente->saldo_ahorro1 = $request->saldo_ahorro + $request->interes_generado;
            $cliente->saldo_ahorro += $request->interes_generado;
            $cliente->save();

            $ultimaTransaccion = Transaccione::latest('id')->first();
            $saldoAnterior = $ultimaTransaccion ? $ultimaTransaccion->saldo : 0;

            // Registrar la transacción (movimiento interno por pago de interés)
            $transaccion = new Transaccione();
            $transaccion->tipo_transaccion = 'movimiento interno';
            $transaccion->tipo_transaccion1 = 'retiro ahorro';
            $transaccion->detalle = 'movimiento por ahorro de interes del cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
            $transaccion->monto = $request->interes_generado;
            $transaccion->saldo = $saldoAnterior;
            $transaccion->fecha = Carbon::now();
            $transaccion->save();

            //creacion plan de ahorro
            $resultado = $this->crearPlanAhorro($request, $cliente);

            // Verificar el resultado del plan de ahorro
            if ($resultado !== true) {
                return $resultado; // Esto será la redirección con error si falla
            }
        } else {
            return redirect()->back()
                ->with('mensaje', 'Acción no válida.')
                ->with('icono', 'error');
        }

        return redirect()->route('admin.cuotas.interes')
            ->with('mensaje', 'Interes generado y retirado exitosamente')
            ->with('icono', 'success');
    }

    protected function crearPlanAhorro(Request $request, Cliente $cliente)
    {
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        // Validar que solo se ejecute en diciembre o enero
        if ($currentMonth != 12 && $currentMonth != 1) {
            return redirect()->back()
                ->with('mensaje', 'Acción no válida.')
                ->with('icono', 'error');
        }

        $startYear = ($currentMonth == 12) ? $currentYear + 1 : $currentYear;
        $startDate = Carbon::create($startYear, 1, 1);
        $totalMonths = 12;

        $configuracion = \App\Models\Configuracion::first(); // Ajusta según tu modelo

        for ($i = 0; $i < $totalMonths; $i++) {
            $pago = new Ahorro();
            $pago->cliente_id = $cliente->id;
            $pago->monto_ahorro = ($request->monto_cuota ?? 1) * $cliente->acciones * $configuracion->valor_accion;
            $fechaVencimiento = $startDate->copy()->addMonths($i)->day(10);
            $pago->fecha_vencimiento = $fechaVencimiento;
            $pago->metodo_pago = "Efectivo";
            $pago->referencia_pago = "Pago del ahorro mes " . $fechaVencimiento->translatedFormat('F Y');
            $pago->estado = "Pendiente";
            $pago->save();
        }

        return true; // Éxito, no interrumpe el flujo
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $datos = request()->all();
        // return response()->json($datos);
        // Validar los datos recibidos
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'total_monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'detalle_pago' => 'required|string',
            'pagos_seleccionados' => 'required|string',
            'montos_pagos' => 'required|string',
        ]);

        // Separar los IDs compuestos y los montos
        $pagosSeleccionados = explode(',', $request->pagos_seleccionados); // ["prestamo_1", "ahorro_1"]
        $montosPagos = explode(',', $request->montos_pagos); // ["237.67", "100"]

        // Validar que la cantidad de pagos y montos coincida
        if (count($pagosSeleccionados) !== count($montosPagos)) {
            return redirect()->back()
                ->with('mensaje', 'El número de pagos seleccionados no coincide con los montos.')
                ->with('icono', 'error');
        }

        // Obtener el cliente
        $cliente = Cliente::findOrFail($request->cliente_id);

        // Obtener el último saldo registrado para las transacciones
        $ultimaTransaccion = Transaccione::latest('id')->first();
        $saldoAnterior = $ultimaTransaccion ? $ultimaTransaccion->saldo : 0;

        // Obtener el último saldo pendiente de la ultima cuota pagada

        $pago = new Pago();
        $pago->cliente_id = $cliente->id;
        $pago->total_pago = $request->total_monto;
        $pago->metodo_pago = $request->metodo_pago;
        $pago->fecha_pago = $request->fecha_pago;
        $pago->detalle_pago = $request->detalle_pago;
        $pago->save();


        // Procesar cada pago seleccionado
        foreach ($pagosSeleccionados as $index => $pagoId) {

            $monto = (float) $montosPagos[$index];
            [$tipo, $id] = explode('-', $pagoId); // Separar "prestamo_1" en ["prestamo", "1"]
            $multas = array_map('floatval', explode(',', $request->input('multas_pagos')));
            if ($tipo === 'cuota') {
                // Actualizar la cuota de préstamo
                $cuota = Cuota::findOrFail($id);
                $cuota->estado = 'Pagado';
                $cuota->metodo_pago = $request->metodo_pago;
                $cuota->fecha_pago = $request->fecha_pago;
                $cuota->detalle_pago = $request->detalle_pago;
                $cuota->pago_id = $pago->id;
                $cuota->multa = $multas[$index]; // Corrección aquí
                $cuota->save();

                // Actualizar el préstamo (restar el monto al monto_total)
                $prestamo = Prestamo::findOrFail($cuota->prestamo_id);
                $prestamo->monto_total -= $monto;
                if ($prestamo->monto_total <= 0) {
                    $prestamo->monto_total = 0;
                    $prestamo->estado = 'Cancelado';
                }
                $prestamo->save();


                // Registrar la transacción (ingreso por pago de préstamo)
                $saldoAnterior += $monto; // Ingreso, suma al saldo
                $transaccion = new Transaccione();
                $transaccion->tipo_transaccion = 'ingreso';
                $transaccion->tipo_transaccion1 = 'pago prestamo';
                $transaccion->detalle = 'pago prestamo cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
                $transaccion->pago_id = $pago->id;
                $transaccion->monto = $monto;
                $transaccion->saldo = $saldoAnterior;
                $transaccion->fecha = new Carbon($request->fecha_pago);
                $transaccion->save();
            } elseif ($tipo === 'ahorro') {
                // Actualizar la cuota de ahorro
                $ahorro = Ahorro::findOrFail($id);
                $ahorro->estado = 'Pagado';
                $ahorro->metodo_pago = $request->metodo_pago;
                $ahorro->fecha_pago = $request->fecha_pago;
                $ahorro->detalle_pago = $request->detalle_pago;
                $ahorro->pago_id = $pago->id;
                $ahorro->multa = $multas[$index];
                $ahorro->save();

                // Sumar el monto al saldo_ahorro del cliente
                $cliente->saldo_ahorro += $monto;
                $cliente->save();

                // Registrar la transacción (ingreso por pago de ahorro)
                $saldoAnterior += $monto; // Ingreso, suma al saldo
                $transaccion = new Transaccione();
                $transaccion->tipo_transaccion = 'ingreso';
                $transaccion->tipo_transaccion1 = 'pago ahorro';
                $transaccion->detalle = 'pago ahorro cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
                $transaccion->pago_id = $pago->id;
                $transaccion->monto = $monto;
                $transaccion->saldo = $saldoAnterior;
                $transaccion->fecha = Carbon::parse($request->fecha_pago);
                $transaccion->save();
            } elseif ($tipo === 'precancelacion') {


                // Actualizar la cuota de préstamo
                $cuota = Cuota::findOrFail($id);
                $cuota->estado = 'Pagado';

                if ($cuota->monto_cuota != $monto) {
                    $cuota->monto_cuota = $monto;
                    if ($cuota->saldo_pendiente != 0) {
                        $cuota->saldo_pendiente -= $cuota->interes;
                    }
                    $cuota->interes = 0;
                }

                $cuota->metodo_pago = $request->metodo_pago;
                $cuota->fecha_pago = $request->fecha_pago;
                $cuota->detalle_pago = $request->detalle_pago . 'Recalculo por Pre-Cancelacion ';
                $cuota->pago_id = $pago->id;
                $cuota->multa = $multas[$index];
                $cuota->save();

                // Actualizar el préstamo (restar el monto al monto_total)
                $prestamo = Prestamo::findOrFail($cuota->prestamo_id);
                $prestamo->monto_total -= $monto;
                $prestamo->estado = 'Cancelado';
                $prestamo->save();



                // Registrar la transacción (ingreso por pago de préstamo)
                $saldoAnterior += $monto; // Ingreso, suma al saldo
                $transaccion = new Transaccione();
                $transaccion->tipo_transaccion = 'ingreso';
                $transaccion->tipo_transaccion1 = 'precancelacion';
                $transaccion->detalle = 'Precancelacion prestamo cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
                $transaccion->pago_id = $pago->id;
                $transaccion->monto = $monto;
                $transaccion->saldo = $saldoAnterior;
                $transaccion->fecha = new Carbon($request->fecha_pago);
                $transaccion->save();
            }
        }
        // Buscar el préstamo
        $prestamoPagado = Prestamo::where('cliente_id', $request->cliente_id)
            ->where('estado', 'Cancelado')
            ->where('monto_total', '!=', 0)
            ->first();
        // Verificar si se encontró un préstamo
        if ($prestamoPagado) {
            // Calcular la diferencia: monto_total1 - monto_total
            $prestamoPagado->monto_total1 = $prestamoPagado->monto_total1 - $prestamoPagado->monto_total;

            // Establecer monto_total a 0
            $prestamoPagado->monto_total = 0;

            // Guardar los cambios
            $prestamoPagado->save();
        }

        $multas = array_map('floatval', explode(',', $request->input('multas_pagos')));
        // Calcular el total de multas pagadas
        $totalMultas = array_sum($multas);

        if ($totalMultas > 0) {
            // Registrar la transacción (ingreso por pago de préstamo)
            $saldoAnterior += $totalMultas; // Ingreso, suma al saldo
            $transaccion = new Transaccione();
            $transaccion->tipo_transaccion = 'ingreso';
            $transaccion->tipo_transaccion1 = 'multa';
            $transaccion->detalle = 'Multa por retrasos: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
            $transaccion->pago_id = $pago->id;
            $transaccion->monto = $totalMultas;
            $transaccion->saldo = $saldoAnterior;
            $transaccion->fecha = new Carbon($request->fecha_pago);
            $transaccion->save();
        }

        return redirect()->route('admin.cuotas.index')
            ->with('mensaje', 'Pagos registrados exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pagos = Pago::find($id);
        $clientes = Cliente::whereHas('pagos', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        $ahorros = Ahorro::where('cliente_id', $clientes->first()->id)
            ->where('pago_id', $pagos->id)
            ->whereNotNull('fecha_pago')
            ->get();
        $cuotas = Cuota::whereHas('prestamo', function ($query) use ($clientes, $pagos) {
            $query->where('cliente_id', $clientes->first()->id)
                ->where('pago_id', $pagos->id);
        })->whereNotNull('fecha_pago')->get();
        return view('admin.cuotas.show', compact('cuotas', 'ahorros', 'pagos', 'clientes'));
    }



    /**
     * Genera el PDF de los recibos de pago.
     */
    public function recibos($id)
    {
        $pago = Pago::find($id);
        if (!$pago) {
            return redirect()->route('admin.cuotas.index')
                ->with('mensaje', 'Pago no encontrado')
                ->with('icono', 'error');
        }
        $configuracion = Configuracion::latest()->first();
        $cliente = Cliente::find($pago->cliente_id);
        $cuotas = Cuota::where('pago_id', $id)->get();
        $ahorro = Ahorro::where('pago_id', $id)->get();

        $pdf = PDF::loadView('admin.cuotas.recibos', compact('pago', 'cliente', 'cuotas', 'configuracion', 'ahorro'));
        $pdf->setPaper('A4', 'portrait');
        // Generar el PDF
        $pdf->render(); // Esto es necesario para obtener la cantidad total de páginas


        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuota $cuota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuota $cuota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuota $cuota)
    {
        //
    }
}
