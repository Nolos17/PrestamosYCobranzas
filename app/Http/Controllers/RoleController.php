<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Se registró el rol de la manera correcta')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $role = Role::find($id);
        return view('admin.roles.show', compact('role'));
    }

    public function asignar_roles($id)
    {
        $rol = Role::find($id);
        $permisos = Permission::all()->groupBy(function ($permiso) {
            if (stripos($permiso->name, 'config') !== false) return 'Configuración';
            elseif (stripos($permiso->name, 'rol') !== false) return 'Roles';
            elseif (stripos($permiso->name, 'use') !== false) return 'Usuarios';
            elseif (stripos($permiso->name, 'cliente') !== false) return 'Clientes';
            elseif (stripos($permiso->name, 'presta') !== false) return 'Préstamos';
            elseif (stripos($permiso->name, 'cuot') !== false) return 'Pagos';
            elseif (stripos($permiso->name, 'reti') !== false) return 'Retiros';
            return 'Otros';
        });
        return view('admin.roles.asignar', compact('rol', 'permisos'));
    }

    public function update_asignar(Request $request, $id)
    {
        $rol = Role::findOrFail($id);
        $permisosSeleccionados = $request->input('permisos', []);
        $rol->permissions()->sync($permisosSeleccionados);
        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Se actualizaron los permisos del rol correctamente')
            ->with('icono', 'success');
    }

    public function edit($id)
    {
        $roles = Role::find($id);
        return view('admin.roles.edit', compact('roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $roles = Role::find($id);
        $roles->name = $request->name;
        $roles->save();
        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Se modificó el rol de la manera correcta')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $roles = Role::find($id);
        Storage::delete('public/' . $roles->logo); // Asegúrate de que 'logo' exista o elimina esta línea
        Role::destroy($id);
        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Se eliminó el rol de la manera correcta')
            ->with('icono', 'success');
    }
}
