<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Prestamo;
use App\Models\Transaccione;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $configuracion = Configuracion::latest()->first();
        return view('admin.clientes.create', compact('configuracion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $configuracion = Configuracion::latest()->first();
        // $datos = request()->all();
        // return response()->json($datos);
        $request->validate([

            'nro_documento' => 'required|unique:clientes',
            'apellidos' => 'required',
            'nombres' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'ref_celular' => 'required',
            'acciones' => 'required',
            'fecha_afiliacion' => 'required',

        ]);

        $cliente = new Cliente();
        $cliente->nro_documento = $request->nro_documento;
        $cliente->apellidos = $request->apellidos;
        $cliente->nombres = $request->nombres;
        $cliente->fecha_nacimiento = $request->fecha_nacimiento;
        $cliente->genero = $request->genero;
        $cliente->email = $request->email;
        $cliente->celular = $request->celular;
        $cliente->ref_celular = $request->ref_celular;
        $cliente->acciones = $request->acciones;
        $cliente->fecha_afiliacion = $request->fecha_afiliacion;
        $cliente->saldo_ahorro = $request->saldo_ahorro;
        $cliente->saldo_ahorro1 = $request->saldo_ahorro;
        $cliente->save();

        //creacion plan de ahorro
        $fechaAfiliacion = Carbon::parse($cliente->fecha_afiliacion);
        $mesAfiliacion = $fechaAfiliacion->month;

        $totalMonths = 12 - $mesAfiliacion + 1;

        for ($i = 0; $i < $totalMonths; $i++) {
            $pago = new Ahorro();
            $pago->cliente_id = $cliente->id;
            $pago->monto_ahorro = ($request->monto_cuota ?? 1) * $cliente->acciones * $configuracion->valor_accion;
            $fechaVencimiento = $fechaAfiliacion->copy()->startOfMonth()->addMonths($i)->day(10);
            $pago->fecha_vencimiento = $fechaVencimiento;
            $pago->metodo_pago = "Efectivo";
            $pago->referencia_pago = "Pago del ahorro mes " . $fechaVencimiento->translatedFormat('F Y');
            $pago->estado = "Pendiente";
            $pago->save();
        }

        $transaccion = Transaccione::latest('id')->first();
        $saldo = $transaccion && !is_null($transaccion->saldo) ? $transaccion->saldo : 0;
        //Crear una transaccion
        $transaccion = new Transaccione();
        $transaccion->tipo_transaccion = 'ingreso';
        $transaccion->tipo_transaccion1 = 'ahorro inicial';
        $transaccion->monto = $request->saldo_ahorro;
        $transaccion->saldo = $saldo + $request->saldo_ahorro;
        $transaccion->detalle = 'Ahorro inicial del Cliente: ' . $cliente->nombres;
        $transaccion->fecha = Carbon::now();
        $transaccion->save();


        return redirect()->route('admin.clientes.index')
            ->with('mensaje', 'Se registró el cliente de la manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        $ahorros = Ahorro::where('cliente_id', $id)->get();
        $prestamos = Prestamo::where('cliente_id', $id)->get();
        return view('admin.clientes.show', compact('cliente', 'ahorros', 'prestamos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $cliente = Cliente::find($id);
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function deshabilitar_cliente($id)
    {

        $cliente = Cliente::find($id);
        return view('admin.clientes.deshabilitar_cliente', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function deshabilitar($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verificar si el cliente tiene préstamos activos
        $prestamosActivos = $cliente->prestamos()
            ->where('estado', 'Activo') // Ajusta 'Activo' según el valor en tu base de datos
            ->count();

        if ($prestamosActivos > 0) {
            return redirect()->route('admin.clientes.index')
                ->with('mensaje', 'No se puede deshabilitar el cliente porque tiene préstamos activos.')
                ->with('icono', 'error');
        }

        // Si no hay préstamos activos, proceder a deshabilitar
        $cliente->estado = 'deshabilitado';
        $cliente->save();

        return redirect()->route('admin.clientes.index')
            ->with('mensaje', 'Se deshabilitó el cliente de manera correcta.')
            ->with('icono', 'success');
    }

    public function update(Request $request, $id)
    {
        $configuracion = Configuracion::latest()->first();
        // $datos = request()->all();
        // return response()->json($datos);
        $request->validate([

            'nro_documento' => 'required|unique:clientes,nro_documento,' . $id,
            'apellidos' => 'required',
            'nombres' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'ref_celular' => 'required',

        ]);


        $cliente = Cliente::find($id);
        if ($cliente->acciones == $request->acciones) {

            $cliente->nro_documento = $request->nro_documento;
            $cliente->apellidos = $request->apellidos;
            $cliente->nombres = $request->nombres;
            $cliente->fecha_nacimiento = $request->fecha_nacimiento;
            $cliente->genero = $request->genero;
            $cliente->email = $request->email;
            $cliente->celular = $request->celular;
            $cliente->ref_celular = $request->ref_celular;
            $cliente->acciones = $request->acciones;
            $cliente->fecha_afiliacion = $request->fecha_afiliacion;
            //cuando se habilite la edicion del saldo inicial del cliente
            //$cliente->saldo_ahorro = $request->saldo_ahorro;
            //$cliente->saldo_ahorro1 = $request->saldo_ahorro;
            $cliente->save();

            return redirect()->route('admin.clientes.index')
                ->with('mensaje', 'No se puede modificar el cliente ')
                ->with('icono', 'success');
        } else {
            Ahorro::where('cliente_id', $id)->where('estado', 'Pendiente')->delete();

            //creacion plan de ahorro
            $ultimoMesAhorro = Ahorro::where('cliente_id', $id)->latest('fecha_vencimiento')->first();
            $startMonth = $ultimoMesAhorro ? Carbon::parse($ultimoMesAhorro->fecha_vencimiento)->month + 1 : Carbon::now()->month;
            $totalMonths = 12 - $startMonth + 1;

            for ($i = 0; $i < $totalMonths; $i++) {
                $pago = new Ahorro();
                $pago->cliente_id = $cliente->id;
                $pago->monto_ahorro = ($request->monto_cuota ?? 1) * $request->acciones * $configuracion->valor_accion;
                $fechaVencimiento = Carbon::now()->startOfMonth()->month($startMonth + $i)->day(10);
                $pago->fecha_vencimiento = $fechaVencimiento;
                $pago->metodo_pago = "Efectivo";
                $pago->referencia_pago = "Pago del ahorro mes " . $fechaVencimiento->translatedFormat('F Y');
                $pago->estado = "Pendiente";
                $pago->save();
            }



            $cliente->nro_documento = $request->nro_documento;
            $cliente->apellidos = $request->apellidos;
            $cliente->nombres = $request->nombres;
            $cliente->fecha_nacimiento = $request->fecha_nacimiento;
            $cliente->genero = $request->genero;
            $cliente->email = $request->email;
            $cliente->celular = $request->celular;
            $cliente->ref_celular = $request->ref_celular;
            $cliente->acciones = $request->acciones;
            $cliente->fecha_afiliacion = $request->fecha_afiliacion;
            //cuando se habilite la edicion del saldo inicial del cliente
            //$cliente->saldo_ahorro = $request->saldo_ahorro;
            //$cliente->saldo_ahorro1 = $request->saldo_ahorro;
            $cliente->save();


            return redirect()->route(route: 'admin.clientes.index')
                ->with(key: 'mensaje', value: 'Se modificó el cliente de la manera correcta')
                ->with(key: 'icono', value: 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        Cliente::destroy($id);

        return redirect()->route(route: 'admin.clientes.index')
            ->with(key: 'mensaje', value: 'Se eliminó el cliente de la manera correcta')
            ->with(key: 'icono', value: 'success');
    }
}
