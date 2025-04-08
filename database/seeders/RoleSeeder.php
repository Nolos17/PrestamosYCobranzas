<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o recuperar el rol ADMINISTRADOR
        $admin = Role::firstOrCreate(['name' => 'ADMINISTRADOR', 'guard_name' => 'web']);

        // Lista de permisos únicos organizados por sección
        $permissions = [
            // Rutas para Configuraciones
            'admin.configuracion.index',
            'admin.configuracion.create',
            'admin.configuracion.store',
            'admin.configuracion.show',
            'admin.configuracion.edit',
            'admin.configuracion.update',
            'admin.configuracion.destroy',
            // Rutas para Roles
            'admin.roles.index',
            'admin.roles.create',
            'admin.roles.store',
            'admin.roles.show',
            'admin.roles.asignar_roles',
            'admin.roles.update_asignar',
            'admin.roles.edit',
            'admin.roles.update',
            'admin.roles.destroy',
            // Rutas para Usuarios
            'admin.users.index',
            'admin.users.create',
            'admin.users.store',
            'admin.users.show',
            'admin.users.edit',
            'admin.users.update',
            'admin.users.destroy',
            // Rutas para Clientes
            'admin.clientes.index',
            'admin.clientes.create',
            'admin.clientes.store',
            'admin.clientes.show',
            'admin.clientes.edit',
            'admin.clientes.update',
            'admin.clientes.destroy',
            'admin.clientes.deshabilitar',

            // Rutas para Préstamos
            'admin.prestamos.index',
            'admin.prestamos.create',
            'admin.prestamos.cliente.obtenerCliente',
            'admin.prestamos.store',
            'admin.prestamos.show',
            'admin.prestamos.contratos',
            // Rutas para Pagar o Cuotas
            'admin.cuotas.index',
            'admin.cuotas.create',
            'admin.cuotas.cliente.obtenerCliente',
            'admin.cuotas.pagos-pendientes',
            'admin.cuotas.ahorros-pendientes',
            'admin.cuotas.store',
            'admin.cuotas.show',
            'admin.cuotas.recibos',
            'admin.cuotas.interes',
            'admin.cuotas.pagarinteres',
            'admin.cuotas.store1',

            // Rutas para Retiros
            'admin.retiros.index',
            'admin.retiros.create',
            'admin.retiros.cliente.obtenerCliente',
            'admin.retiros.store',
            'admin.retiros.show',
            'admin.retiros.recibos',
            //Rutas para backups
            'admin.backups.index',
            'admin.backups.create',



        ];

        // Crear o recuperar permisos y asignarlos al rol $admin
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'])->syncRoles([$admin]);
        }
    }
}
