<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('admin');
});




Auth::routes();


Route::get('home/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index.home')->middleware(['auth']);
Route::get('admin/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware(['auth']);

//rutas para configuraciones
Route::get('admin/configuraciones', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('admin.configuracion.index')->middleware(['auth', 'can:admin.configuracion.index']);
Route::get('admin/configuraciones/create', [App\Http\Controllers\ConfiguracionController::class, 'create'])->name('admin.configuracion.create')->middleware(['auth', 'can:admin.configuracion.create']);
Route::post('admin/configuraciones/create', [App\Http\Controllers\ConfiguracionController::class, 'store'])->name('admin.configuracion.store')->middleware(['auth', 'can:admin.configuracion.store']);
Route::get('admin/configuraciones/{id}', [App\Http\Controllers\ConfiguracionController::class, 'show'])->name('admin.configuracion.show')->middleware(['auth', 'can:admin.configuracion.show']);
Route::get('admin/configuraciones/{id}/edit', [App\Http\Controllers\ConfiguracionController::class, 'edit'])->name('admin.configuracion.edit')->middleware(['auth', 'can:admin.configuracion.edit']);
Route::put('admin/configuraciones/{id}', [App\Http\Controllers\ConfiguracionController::class, 'update'])->name('admin.configuracion.update')->middleware(['auth', 'can:admin.configuracion.update']);
Route::delete('admin/configuraciones/{id}', [App\Http\Controllers\ConfiguracionController::class, 'destroy'])->name('admin.configuracion.destroy')->middleware(['auth', 'can:admin.configuracion.destroy']);

//rutas para Roles
Route::get('admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware(['auth', 'can:admin.roles.index']);
Route::get('admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware(['auth', 'can:admin.roles.create']);
Route::post('admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware(['auth', 'can:admin.roles.store']);
Route::get('admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show')->middleware(['auth', 'can:admin.roles.show']);
Route::get('admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware(['auth', 'can:admin.roles.edit']);
Route::put('admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware(['auth', 'can:admin.roles.update']);
Route::delete('admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware(['auth', 'can:admin.roles.destroy']);
Route::get('admin/roles/{id}/asignar', [App\Http\Controllers\RoleController::class, 'asignar_roles'])->name('admin.roles.asignar_roles')->middleware(['auth', 'can:admin.roles.asignar_roles']);
Route::put('admin/roles/asignar/{id}', [App\Http\Controllers\RoleController::class, 'update_asignar'])->name('admin.roles.update_asignar')->middleware(['auth', 'can:admin.roles.update_asignar']);

//rutas para Users
Route::get('admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index')->middleware(['auth', 'can:admin.users.index']);
Route::get('admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create')->middleware(['auth', 'can:admin.users.create']);
Route::post('admin/users/create', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store')->middleware(['auth', 'can:admin.users.store']);
Route::get('admin/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('admin.users.show')->middleware(['auth', 'can:admin.users.show']);
Route::get('admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit')->middleware(['auth', 'can:admin.users.edit']);
Route::put('admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update')->middleware(['auth', 'can:admin.users.update']);
Route::delete('admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy')->middleware(['auth', 'can:admin.users.destroy']);

//rutas para Clientes
Route::get('admin/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('admin.clientes.index')->middleware(['auth', 'can:admin.clientes.index']);
Route::get('admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'create'])->name('admin.clientes.create')->middleware(['auth', 'can:admin.clientes.create']);
Route::post('admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'store'])->name('admin.clientes.store')->middleware(['auth', 'can:admin.clientes.store']);
Route::get('admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'show'])->name('admin.clientes.show')->middleware(['auth', 'can:admin.clientes.show']);
Route::get('admin/clientes/{id}/edit', [App\Http\Controllers\ClienteController::class, 'edit'])->name('admin.clientes.edit')->middleware(['auth', 'can:admin.clientes.edit']);
Route::put('admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'update'])->name('admin.clientes.update')->middleware(['auth', 'can:admin.clientes.update']);
Route::put('admin/clientes/deshabilitar/{id}', [App\Http\Controllers\ClienteController::class, 'deshabilitar'])->name('admin.clientes.deshabilitar')->middleware(['auth', 'can:admin.clientes.deshabilitar']);
Route::delete('admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('admin.clientes.destroy')->middleware(['auth', 'can:admin.clientes.destroy']);
Route::get('admin/clientes/{id}/deshabilitar', [App\Http\Controllers\ClienteController::class, 'deshabilitar_cliente'])->name('admin.clientes.deshabilitar_cliente')->middleware(['auth', 'can:admin.clientes.deshabilitar_cliente']);

//rutas para prestamos
Route::get('admin/prestamos', [App\Http\Controllers\PrestamoController::class, 'index'])->name('admin.prestamos.index')->middleware(['auth', 'can:admin.prestamos.index']);
Route::get('admin/prestamos/create', [App\Http\Controllers\PrestamoController::class, 'create'])->name('admin.prestamos.create')->middleware(['auth', 'can:admin.prestamos.create']);
Route::get('admin/prestamos/cliente/{id}', [App\Http\Controllers\PrestamoController::class, 'obtenerCliente'])->name('admin.prestamos.cliente.obtenerCliente')->middleware(['auth', 'can:admin.prestamos.cliente.obtenerCliente']);
Route::post('admin/prestamos/create', [App\Http\Controllers\PrestamoController::class, 'store'])->name('admin.prestamos.store')->middleware(['auth', 'can:admin.prestamos.store']);
Route::get('admin/prestamos/{id}', [App\Http\Controllers\PrestamoController::class, 'show'])->name('admin.prestamos.show')->middleware(['auth', 'can:admin.prestamos.show']);
Route::get('admin/prestamos/contratos/{id}', [App\Http\Controllers\PrestamoController::class, 'contratos'])->name('admin.prestamos.contratos')->middleware(['auth', 'can:admin.prestamos.contratos']);

//por adaptar metodos de actualizado y borrado de prestamos
/*Route::get('admin/prestamos/{id}/edit', [App\Http\Controllers\PrestamoController::class, 'edit'])->name('admin.prestamos.edit')->middleware(['auth']);
Route::put('admin/prestamos/{id}', [App\Http\Controllers\PrestamoController::class, 'update'])->name('admin.prestamos.update')->middleware(['auth']);
Route::delete('admin/prestamos/{id}', [App\Http\Controllers\PrestamoController::class, 'destroy'])->name('admin.prestamos.destroy')->middleware(['auth']);
*/

//rutas para cuotas
Route::get('admin/cuotas', [App\Http\Controllers\CuotaController::class, 'index'])->name('admin.cuotas.index')->middleware(['auth', 'can:admin.cuotas.index']);
Route::get('admin/cuotas/interes', [App\Http\Controllers\CuotaController::class, 'interes'])->name('admin.cuotas.interes')->middleware(['auth', 'can:admin.cuotas.interes']);
Route::get('admin/cuotas/interes/{id}', [App\Http\Controllers\CuotaController::class, 'pagarinteres'])->name('admin.cuotas.pagarinteres')->middleware(['auth', 'can:admin.cuotas.pagarinteres']);
Route::get('admin/cuotas/create', [App\Http\Controllers\CuotaController::class, 'create'])->name('admin.cuotas.create')->middleware(['auth', 'can:admin.cuotas.create']);
Route::get('admin/cuotas/cliente/{id}', [App\Http\Controllers\CuotaController::class, 'obtenerCliente'])->name('admin.cuotas.cliente.obtenerCliente')->middleware(['auth', 'can:admin.cuotas.cliente.obtenerCliente']);
Route::get('admin/cuotas/pagos-pendientes/{id}', [App\Http\Controllers\CuotaController::class, 'getPagosPendientes'])->name('admin.cuotas.pagos-pendientes')->middleware(['auth', 'can:admin.cuotas.pagos-pendientes']);
Route::get('admin/cuotas/ahorros-pendientes/{id}', [App\Http\Controllers\CuotaController::class, 'getAhorrosPendientes'])->name('admin.cuotas.ahorros-pendientes')->middleware(['auth', 'can:admin.cuotas.ahorros-pendientes']);
Route::get('admin/cuotas/clientes-prestamos/{id}', [App\Http\Controllers\CuotaController::class, 'getPrestamosCliente'])->name('admin.cuotas.clientes-prestamos')->middleware(['auth']);
Route::post('admin/cuotas/create', [App\Http\Controllers\CuotaController::class, 'store'])->name('admin.cuotas.store')->middleware(['auth', 'can:admin.cuotas.store']);
Route::post('admin/cuotas/interes', [App\Http\Controllers\CuotaController::class, 'store1'])->name('admin.cuotas.store1')->middleware(['auth', 'can:admin.cuotas.store1']);
Route::get('admin/cuotas/{id}', [App\Http\Controllers\CuotaController::class, 'show'])->name('admin.cuotas.show')->middleware(['auth', 'can:admin.cuotas.show']);
Route::get('admin/cuotas/recibos/{id}', [App\Http\Controllers\CuotaController::class, 'recibos'])->name('admin.cuotas.recibos')->middleware(['auth', 'can:admin.cuotas.recibos']);

//por adaptar metodos de actualizado
/*Route::get('admin/cuotas/{id}/edit', [App\Http\Controllers\CuotaController::class, 'edit'])->name('admin.cuotas.edit')->middleware(['auth']);
Route::put('admin/cuotas/{id}', [App\Http\Controllers\CuotaController::class, 'update'])->name('admin.cuotas.update')->middleware(['auth']);
Route::delete('admin/cuotas/{id}', [App\Http\Controllers\CuotaController::class, 'destroy'])->name('admin.cuotas.destroy')->middleware(['auth']);
*/

//rutas para retiros
Route::get('admin/retiros', [App\Http\Controllers\RetiroController::class, 'index'])->name('admin.retiros.index')->middleware(['auth', 'can:admin.retiros.index']);
Route::get('admin/retiros/create', [App\Http\Controllers\RetiroController::class, 'create'])->name('admin.retiros.create')->middleware(['auth', 'can:admin.retiros.create']);
Route::get('admin/retiros/cliente/{id}', [App\Http\Controllers\RetiroController::class, 'obtenerCliente'])->name('admin.retiros.cliente.obtenerCliente')->middleware(['auth', 'can:admin.retiros.cliente.obtenerCliente']);
Route::post('admin/retiros/create', [App\Http\Controllers\RetiroController::class, 'store'])->name('admin.retiros.store')->middleware(['auth', 'can:admin.retiros.store']);
Route::get('admin/retiros/{id}', [App\Http\Controllers\RetiroController::class, 'show'])->name('admin.retiros.show')->middleware(['auth', 'can:admin.retiros.show']);
Route::get('admin/retiros/recibos1/{id}', [App\Http\Controllers\RetiroController::class, 'recibos1'])->name('admin.retiros.recibos1')->middleware(['auth']);

//por adaptar metodos de actualizado y borrado de retiros
/*Route::get('admin/retiros/{id}/edit', [App\Http\Controllers\RetiroController::class, 'edit'])->name('admin.retiros.edit')->middleware(['auth']);
Route::put('admin/retiros/{id}', [App\Http\Controllers\RetiroController::class, 'update'])->name('admin.retiros.update')->middleware(['auth']);
Route::delete('admin/retiros/{id}', [App\Http\Controllers\RetiroController::class, 'destroy'])->name('admin.retiros.destroy')->middleware(['auth']);
*/

Route::get('admin/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('admin.reportes.index')->middleware(['auth']);
Route::get('admin/reportes/prestamos1', [App\Http\Controllers\ReporteController::class, 'prestamos1'])->name('admin.reportes.prestamos1')->middleware(['auth']);
Route::get('admin/reportes/prestamos2', [App\Http\Controllers\ReporteController::class, 'prestamos2'])->name('admin.reportes.prestamos2')->middleware(['auth']);
Route::get('admin/reportes/ahorros1', [App\Http\Controllers\ReporteController::class, 'ahorros1'])->name('admin.reportes.ahorros1')->middleware(['auth']);
Route::get('admin/reportes/transacciones', [App\Http\Controllers\ReporteController::class, 'transacciones'])->name('admin.reportes.transacciones')->middleware(['auth']);


Route::get('admin/backups', [App\Http\Controllers\BackupController::class, 'index'])->name('admin.backups.index')->middleware(['auth']);
Route::get('admin/backups/create', [App\Http\Controllers\BackupController::class, 'create'])->name('admin.backups.create')->middleware(['auth']);
Route::get('admin/backups/download/{filename}', [App\Http\Controllers\BackupController::class, 'download'])->name('admin.backups.download')->middleware(['auth']);
