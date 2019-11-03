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

            /*NULL atau kosong berarti untuk superadmin dan admin yang tidak mempunyai jenis karantina*/
            if (is_null($cek) || $cek === '' || $cek === 'kt' ) return $next($request);

<<<<<<< HEAD
            return back()->withWarning('Hak Akses Hanya Untuk Fungsional Karantina Tumbuhan!');
=======
            return back()->withWarning('Anda Tidak Mempunyai Hak Akses Ke Halaman Ini!');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                
        }

        return redirect(route('login'));
    }
}
