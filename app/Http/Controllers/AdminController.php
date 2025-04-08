<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $total_roles = Role::count();
        $total_users = User::count();
        $total_configuraciones = Configuracion::count();
        $total_clientes = Cliente::count();
        return view('admin.index', compact('total_configuraciones', 'total_users', 'total_roles', 'total_clientes'));
    }
}
