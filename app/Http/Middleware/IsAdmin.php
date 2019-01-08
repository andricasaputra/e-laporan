<?php

namespace App\Http\Middleware;

use Closure;

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
        if (auth()->user()) {

            $cek = auth()->user()->role->first()->id;

            if ($cek  === 2 || $cek  === 3) {

                return $next($request);
                
            }else{

                return redirect(route('welcome'))
                        ->with('warning', "Maaf anda tidak mempunyai hak akses ke halaman ini");

            }

        }
         
        return redirect(route('login'));
    }
}