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

            if (Auth::user()->bagian == '-' || Auth::user()->bagian == 'kt') {

                return $next($request);

            }   
                
         }

        return redirect(route('login'));
    }
}
