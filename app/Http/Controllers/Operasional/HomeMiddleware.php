<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HomeMiddleware extends Controller
{
    /**
     *Dynamic Middleware pass to here
     * 
     * @return string
     */
    private static $use_middleware;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return $this->middleware(self::$use_middleware);
    }

    /**
     *Set What Middleware to use if user authenticated 
     *and send it to static property $use_middleware
     *
     * @return void 
     */
    private function useMiddleware($middleware = 'admin')
    {
        return self::$use_middleware = $middleware;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function operasional()
    {
        if (!Auth::user()) {

            return redirect(route('login'));
            
        }

        $cek1 = Auth::user()->role->first()->id;

        $cek2 = Auth::user()->pegawai->jenis_karantina;

        if($cek1 === 1 || $cek1 === 2 || $cek1 === 3):

            $this->useMiddleware('admin');

            return redirect('intern/operasional/home/');

        elseif($cek1 === 4 && $cek2 == 'kt'):
           
            $this->useMiddleware('kt');

            return redirect('intern/operasional/home/');

        elseif($cek1 === 4 && $cek2 == 'kh'):

            $this->useMiddleware('kh');

            return redirect('intern/operasional/home/');

        elseif($cek1 === 4 && $cek2 !== 'kh' && $cek2 !== 'kt'):

            $this->useMiddleware('guest');

            return redirect('intern/operasional/home/');

        else:

            return redirect(route('welcome'))->with('warning', 'Maaf anda tidak mempunyai hak akses ke halaman ini');

        endif;   
    }
}
