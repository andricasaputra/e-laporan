<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeMiddleware extends Controller
{
    /**
     * Dynamic Middleware pass to here
     * 
     * @return string
     */
    private static $shouldUseMiddleware;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return $this->middleware(static::$shouldUseMiddleware);
    }

    /**
     * Set What Middleware to use if user authenticated 
     * and send it to static property $shouldUseMiddleware
     *
     * @return void 
     */
    private static function useMiddleware($middleware = 'admin')
    {
        return static::$shouldUseMiddleware = $middleware;
    }

    /**
     * Show the application dashboard based on role type.
     *
     * @return void
     */
    public function operasional()
    {
        if (! auth()->user()) return redirect(route('login'));
            
        $cek1 = auth()->user()->role->first()->id;

        $cek2 = auth()->user()->pegawai->jenis_karantina;

        if($cek1 === 1 || $cek1 === 2 || $cek1 === 3):

            static::useMiddleware('admin');

        elseif($cek1 === 4 && $cek2 == 'kt'):
           
            static::useMiddleware('kt');

        elseif($cek1 === 4 && $cek2 == 'kh'):

            static::useMiddleware('kh');

        elseif($cek1 === 4 && $cek2 !== 'kh' && $cek2 !== 'kt'):

            static::useMiddleware('guest');

        else:

            return redirect(route('welcome'))
                    ->with('warning', 'Maaf anda tidak mempunyai hak akses ke halaman ini');

        endif; 

        return redirect('intern/operasional/home/');  
    }
}
