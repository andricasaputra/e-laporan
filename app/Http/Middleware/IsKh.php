<?php

namespace App\Http\Middleware;

use Closure;

class IsKh
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

            $cek = auth()->user()->pegawai->jenis_karantina;

            if ($cek === NULL || $cek === 'kh' ) return $next($request); 

            return back()->withWarning('Anda Tidak Mempunyai Hak Akses Ke Halaman Ini!');
                
        }

        return redirect(route('login'));
    }
}
