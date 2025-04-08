<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Retiro;
use App\Models\Transaccione;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RetiroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $retiro = Retiro::all();
        return view('admin.retiros.index', compact('retiro'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaccion = Transaccione::latest('id')->first();
        $saldo = $transaccion && !is_null($transaccion->saldo) ? $transaccion->saldo : 0;

        $clientes = Cliente::all();

        return view('admin.retiros.create', compact('clientes', 'saldo'));
    }

    public function obtenerCliente($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }
        return response()->json($cliente);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'saldo_ahorro' => 'required|numeric|min:0',
            'monto_retirar' => 'required|numeric|min:0',
            'fecha_retiro' => 'required|date',
            'detalle_retiro' => 'required|string|max:255',
        ]);

        if ($request->monto_retirar > $request->saldo_ahorro) {
            return redirect()->route('admin.retiro.create')
                ->with('mensaje', 'El monto a retirar no puede ser mayor que el saldo de ahorro.')
                ->with('icono', 'error');
        }
        $retiro = new Retiro();
        $retiro->cliente_id = $request->cliente_id;
        $retiro->total_retiro = $request->monto_retirar;
        $retiro->metodo_retiro = 'Efectivo';
        $retiro->fecha_retiro = $request->fecha_retiro;
        $retiro->detalle_retiro = $request->detalle_retiro;
        $retiro->estado = 'Realizado';
        $retiro->save();

        // Obtener el cliente
        $cliente = Cliente::findOrFail($request->cliente_id);
        $cliente->saldo_ahorro -= $request->monto_retirar;
        $cliente->saldo_ahorro1 =  $cliente->saldo_ahorro - $request->monto_retirar;
        $cliente->save();


        // Obtener el último saldo registrado para las transacciones
        $ultimaTransaccion = Transaccione::latest('id')->first();
        $saldoAnterior = $ultimaTransaccion ? $ultimaTransaccion->saldo : 0;

        // Registrar la transacción (egreso por retiro de interés)
        $transaccion = new Transaccione();
        $transaccion->tipo_transaccion = 'egreso';
        $transaccion->tipo_transaccion1 = 'retiro ahorro';
        $transaccion->detalle = 'Retiro de Ahorro del cliente: ' . $cliente->nro_documento . ' - ' . $cliente->apellidos . ' ' . $cliente->nombres;
        $transaccion->retiro_id = $retiro->id;
        $transaccion->monto = $request->monto_retirar;
        $saldoAnterior -= $request->monto_retirar;
        $transaccion->saldo = $saldoAnterior;
        $transaccion->fecha = Carbon::now();
        $transaccion->save();

        return redirect()->route('admin.retiros.index')
            ->with('mensaje', 'Retiro generado exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $retiros = Retiro::find($id);
        $clientes = Cliente::whereHas('retiros', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        return view('admin.retiros.show', compact('retiros', 'clientes'));
    }

    public function recibos1($id)
    {
        $retiro = Retiro::find($id);
        if (!$retiro) {
            return redirect()->route('admin.retiros.index')
                ->with('mensaje', 'Pago no encontrado')
                ->with('icono', 'error');
        }
        $configuracion = Configuracion::latest()->first();
        $cliente = Cliente::find($retiro->cliente_id);

        $pdf = PDF::loadView('admin.retiros.recibos1', compact('retiro', 'cliente', 'configuracion'));
        $pdf->setPaper('A4', 'portrait');
        // Generar el PDF
        $pdf->render(); // Esto es necesario para obtener la cantidad total de páginas


        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retiro $retiro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retiro $retiro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retiro $retiro)
    {
        //
    }
}
