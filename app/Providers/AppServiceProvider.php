<?php

namespace App\Providers;

use App\Models\Configuracion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaccione;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $configuracion = Configuracion::first();
        $transaccion = Transaccione::latest('id')->first();  // Ajusta la consulta según sea necesario
        $saldo = $transaccion && !is_null($transaccion->saldo) ? $transaccion->saldo : 0;
        View::share('configuracion', $configuracion);
        View::share('saldo', $saldo);
    }
}
