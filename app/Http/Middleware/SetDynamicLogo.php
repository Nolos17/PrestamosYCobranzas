<?php

namespace App\Http\Middleware;

use App\Models\Configuracion;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDynamicLogo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cargar la configuración desde la base de datos
        $configuracion = Configuracion::first();

        if ($configuracion) {
            // Sobrescribir la imagen del logo
            if ($configuracion->logo) {
                config(['adminlte.logo_img' => 'storage/' . $configuracion->logo]);
            }

            // Sobrescribir el nombre del logo
            if ($configuracion->nombre) {
                config(['adminlte.logo' => $configuracion->nombre]);
            }

            config(['adminlte.logo_img_alt' => 'Mi App Logo']);
        }
        return $next($request);
    }
}
