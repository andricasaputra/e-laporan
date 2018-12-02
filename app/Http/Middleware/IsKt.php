<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        $cek = Auth::user()->pegawai->jenis_karantina;

        if (Auth::user()) {

            if ($cek === NULL || $cek === 'str' || $cek === 'kt' ) {

                return $next($request);

            }   
                
        }

        return redirect(route('login'));
    }
}
