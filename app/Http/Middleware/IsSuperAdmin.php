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

            if ($cek === 1) return $next($request);

<<<<<<< HEAD
            return back()->withWarning('Maaf anda tidak mempunyai hak akses ke halaman ini!');
=======
            return back()->withWarning('Anda Tidak Mempunyai Hak Akses Ke Halaman Ini!');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

        }
         
        return redirect(route('login'));
    }
}