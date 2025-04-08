<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $datos = request()->all();
        // return response()->json($datos);

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',


        ]);

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();

        $users->assignRole($request->rol);

        return redirect()->route('admin.users.index')
            ->with('mensaje', 'Se registró el rol de la manera correcta')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $roles = Role::all();
        $users = User::find($id);
        return view('admin.users.edit', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // $datos = request()->all();
        // return response()->json($datos);
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'confirmed',

        ]);

        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        if ($request->filled('password')) {
            $users->password = Hash::make($request->password);
        }
        $users->save();
        $users->syncRoles($request->rol);

        return redirect()->route(route: 'admin.users.index')
            ->with(key: 'mensaje', value: 'Se modificó al usuario de la manera correcta')
            ->with(key: 'icono', value: 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {


        User::destroy($id);

        return redirect()->route(route: 'admin.users.index')
            ->with(key: 'mensaje', value: 'Se eliminó el usuario de la manera correcta')
            ->with(key: 'icono', value: 'success');
    }
}
