<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Posibles url para conceder permisos de cors
        $possibleOrigins = [
            env('HOST_FRONT'),
            env('HOST_ADMIN'),
         ];

         if (in_array($request->header('origin'), $possibleOrigins)) {
            $origin = $request->header('origin');
         } else {
            $origin = env('HOST_DEFAULT');
         }

        return $next($request)
        //Url a la que se le dará acceso en las peticiones
       ->header("Access-Control-Allow-Origin", $origin)
       //Métodos que a los que se da acceso
       ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
       //Headers de la petición
       ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
}
