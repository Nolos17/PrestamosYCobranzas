<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuota;
use App\Models\Prestamo;
use App\Models\Configuracion;
use App\Models\Retencione;
use App\Models\Transaccione;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = Prestamo::all();
        return view('admin.prestamos.index', compact('prestamos'));
    }
    public function contratos($id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return redirect()->route('admin.prestamos.index')
                ->with('mensaje', 'Préstamo no encontrado')
                ->with('icono', 'error');
        }
        $configuracion = Configuracion::latest()->first();
        $cliente = Cliente::find($prestamo->cliente_id);
        $cuotas = Cuota::where('prestamo_id', $id)->get();

        $pdf = PDF::loadView('admin.prestamos.contratos', compact('prestamo', 'cliente', 'cuotas', 'configuracion'));
        $pdf->setPaper('A4', 'portrait');
        // Generar el PDF
        $pdf->render(); // Esto es necesario para obtener la cantidad total de páginas

        // Obtener el canvas (el lienzo sobre el que se renderiza el PDF)
        $canvas = $pdf->getCanvas();

        // Agregar la numeración de páginas en el pie de página
        $canvas->page_text(150, 800, "*Se retendra el 1% de todo prestamo solicitado para gastos administrativos.*", null, 9, array(0, 0, 0));
        $canvas->page_text(270, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaccion = Transaccione::latest('id')->first();
        $saldo = $transaccion && !is_null($transaccion->saldo) ? $transaccion->saldo : 0;
        $configuracion = Configuracion::latest()->first();
        $clientes = Cliente::all();
        return view('admin.prestamos.create', compact('clientes', 'configuracion', 'saldo'));
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
        //$datos = request()->all();

        // Decodificar las cuotas del campo cuotas_json
        //$cuotas = json_decode($datos['cuotas_json'], true);

        // Mostrar los datos y las cuotas para verificar
        /*return response()->json([
            'datos' => $datos,
            'cuotas' => $cuotas
        ]);*/
        $transaccion = Transaccione::latest('id')->first();
        $configuracion = Configuracion::latest()->first();
        $saldo = $transaccion && !is_null($transaccion->saldo) ? $transaccion->saldo : 0;

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto_prestado' => 'required|numeric|min:1',
            'metodo_prestamo' => 'required|in:Personalizado,Francés,Alemán,Institucional',
            'modalidad' => 'required|in:Diario,Semanal,Quincenal,Mensual,Anual',
            'nro_cuotas' => 'required|integer|min:1',
            'fecha_prestamo' => 'required|date',
            'monto_total' => 'required|numeric|min:1',
            'cuotas_json' => 'required|json',
        ]);

        $transaccion = new Transaccione();
        $transaccion->tipo_transaccion = 'Egreso';
        $transaccion->tipo_transaccion1 = 'prestamo';

        $transaccion->monto = $request->monto_prestado;
        $transaccion->saldo = $saldo - $request->monto_prestado;
        $transaccion->detalle = 'Préstamo otorgado al cliente ID: ' . $request->cliente_id;
        $transaccion->fecha = $request->fecha_prestamo;
        $transaccion->save();

        $prestamo = new Prestamo();
        $prestamo->cliente_id = $request->cliente_id;
        $prestamo->monto_prestado = $request->monto_prestado;
        $prestamo->metodo_prestamo = $request->metodo_prestamo;
        $prestamo->tasa_interes_anual = $request->interes_personalizado;
        $prestamo->modalidad = $request->modalidad;
        $prestamo->nro_cuotas = $request->nro_cuotas;
        $prestamo->fecha_inicio = $request->fecha_prestamo;
        $prestamo->monto_total = $request->monto_total;
        $prestamo->monto_total1 = $request->monto_total;
        $prestamo->save();

        // Valor a retener del prestamo politica interna
        $retencion = new Retencione();
        $retencion->prestamo_id = $prestamo->id;
        $retencion->valor_retenido = $prestamo->monto_prestado * ($configuracion->valor_retencion / 100);
        $retencion->save();


        // Decodificar las cuotas desde el JSON
        $cuotas = json_decode($request->cuotas_json, true);

        foreach ($cuotas as $cuotaData) {
            $cuota = new Cuota();
            $cuota->prestamo_id = $prestamo->id;
            $cuota->monto_cuota = $cuotaData['cuota'];
            $cuota->interes = $cuotaData['interes'];
            $cuota->capital = $cuotaData['capital'];
            $prestamo->monto_total1 -= $cuotaData['cuota'];
            $cuota->saldo_pendiente = $prestamo->monto_total1;
            $cuota->metodo_pago = 'efectivo';

            // Calcular la fecha de vencimiento
            $fecha_vencimiento = \Carbon\Carbon::parse($request->fecha_prestamo)->addMonths($cuotaData['numero']);
            $fecha_vencimiento->day(10); // Ajustar al día 10 de cada mes

            // Obtener el nombre del mes en español (en minúsculas)
            $nombreMes = strtolower($fecha_vencimiento->translatedFormat('F')); // 'F' devuelve el nombre completo del mes

            // Generar el campo referencia_pago
            $cuota->referencia_pago = 'Pago de Cuota número ' . $cuotaData['numero'] . ' correspondiente al pago del mes ' . $nombreMes;

            $cuota->estado = 'Pendiente';
            $cuota->fecha_vencimiento = $fecha_vencimiento;
            $cuota->save();
        }

        return redirect()->route('admin.prestamos.index')
            ->with('mensaje', 'Se registró el prestamo de la manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return redirect()->route('admin.prestamos.index')
                ->with('mensaje', 'Préstamo no encontrado')
                ->with('icono', 'error');
        }

        $cliente = Cliente::find($prestamo->cliente_id);
        $cuotas = Cuota::where('prestamo_id', $id)->get();

        return view('admin.prestamos.show', compact('prestamo', 'cliente', 'cuotas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        //
    }
}
