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
        if (auth()->check()) {

            if (adminn()) return $next($request);
                
            return redirect(route('welcome'))
                    ->withWarning('Maaf anda tidak mempunyai hak akses ke halaman ini!');

        }
         
        return redirect(route('login'));
    }
}