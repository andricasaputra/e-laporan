<?php

namespace App\Http\Middleware;

use Closure;

class IsSuperAdmin
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

            if ($cek === 1) {

                return $next($request);
                
            }

        }
         
        return redirect(route('login'));
    }
}