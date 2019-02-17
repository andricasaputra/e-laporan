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

            $cek = auth()->user()->pegawai->jenis_karantina;

            /*NULL berarti untuk superadmin dan admin yang tidak mempunyai jenis karantina*/
            if ($cek === NULL || $cek === 'kt' ) return $next($request);

            return back()->withWarning('Anda Tidak Mempunyai Hak Akses Ke Halaman Ini!');
                
        }

        return redirect(route('login'));
    }
}
