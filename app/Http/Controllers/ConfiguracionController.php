<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configuraciones = Configuracion::all();
        return view('admin.configuraciones.index', compact('configuraciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.configuraciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $datos = request()->all();
        // return response()->json($datos);

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'moneda' => 'required',
            'logo' => 'required',
            'base_prestamo' => 'required',
            'valor_accion' => 'required',

        ]);

        $configuracion = new Configuracion();
        $configuracion->nombre = $request->nombre;
        $configuracion->descripcion = $request->descripcion;
        $configuracion->direccion = $request->direccion;
        $configuracion->telefono = $request->telefono;
        $configuracion->email = $request->email;
        $configuracion->web = $request->web;
        $configuracion->moneda = $request->moneda;
        $configuracion->logo = $request->file('logo')->store('logos', 'public');
        $configuracion->base_prestamo = $request->base_prestamo;
        $configuracion->valor_accion = $request->valor_accion;
        $configuracion->valor_retencion = $request->valor_retencion;
        $configuracion->valor_mora = $request->valor_mora;
        $configuracion->save();

        return redirect()->route('admin.configuracion.index')
            ->with('mensaje', 'Se registró la configuración de la manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $configuraciones = Configuracion::find($id);
        return view('admin.configuraciones.show', compact('configuraciones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $configuraciones = Configuracion::find($id);
        return view('admin.configuraciones.edit', compact('configuraciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'moneda' => 'required',
            'base_prestamo' => 'required',
            'valor_accion' => 'required',
        ]);

        $configuracion = Configuracion::find($id);
        $configuracion->nombre = $request->nombre;
        $configuracion->descripcion = $request->descripcion;
        $configuracion->direccion = $request->direccion;
        $configuracion->telefono = $request->telefono;
        $configuracion->email = $request->email;
        $configuracion->web = $request->web;
        $configuracion->moneda = $request->moneda;
        $configuracion->base_prestamo = $request->base_prestamo;
        $configuracion->valor_accion = $request->valor_accion;
        $configuracion->valor_retencion = $request->valor_retencion;
        $configuracion->valor_mora = $request->valor_mora;

        if ($request->hasFile('logo')) {
            Storage::delete('public/' . $configuracion->logo);
            $configuracion->logo = $request->file('logo')->store('logos', 'public');
        }

        $configuracion->save();

        return redirect()->route(route: 'admin.configuracion.index')
            ->with(key: 'mensaje', value: 'Se modificó la configuración de la manera correcta')
            ->with(key: 'icono', value: 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $configuracion = Configuracion::find($id);
        Storage::delete(paths: 'public/' . $configuracion->logo);
        Configuracion::destroy($id);

        return redirect()->route(route: 'admin.configuracion.index')
            ->with(key: 'mensaje', value: 'Se eliminó la configuración de la manera correcta')
            ->with(key: 'icono', value: 'success');
    }
}
