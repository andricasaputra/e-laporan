<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            
            if (Auth::guard($guard)->user()->bagian == '-') {

                return redirect(route('home'));

            }elseif(Auth::guard($guard)->user()->bagian == 'kt'){

                return redirect(route('kt.home'));

            }elseif(Auth::guard($guard)->user()->bagian == 'kh'){

                return redirect(route('kh.home'));
            }
        }

        return $next($request);
    }
}
