<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class IsKt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {

            if (Auth::user()->pegawai->jenis_karantina == NULL || Auth::user()->pegawai->jenis_karantina == 'kt') {

                return $next($request);

            }  
                
         }

        return redirect(route('login'));
    }
}
