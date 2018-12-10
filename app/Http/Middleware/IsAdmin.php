<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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

            $cek = Auth::user()->role->first()->id;

            if ($cek  === 2 || $cek  === 3) {

                return $next($request);
                
            }else{

                return redirect(route('welcome'))->with('warning', "Maaf anda tidak mempunyai hak akses ke halaman ini");

            }

        }
         
        return redirect(route('login'));
    }
}