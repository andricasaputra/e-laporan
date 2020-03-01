<?php

namespace App\Http\Middleware;

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
        if (auth()->user()) {

            $cek = auth()->user()->hasRole('kt');

            if ($cek || admin()) return $next($request);

            return back()->withWarning('Hak Akses Hanya Untuk Fungsional Karantina Tumbuhan!');
                
        }

        return redirect(route('login'));
    }
}
