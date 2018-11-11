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
        $this->middleware(self::$use_middleware);
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
        if(Auth::user()->role_id == 1 && Auth::user()->bagian == '-'):

            $this->useMiddleware('admin');

            return redirect('intern/operasional/admin/home/');

        elseif(Auth::user()->role_id != 1 && Auth::user()->bagian == 'kt'):
           
            $this->useMiddleware('kt');

            return redirect('intern/operasional/kt/home/');

        else:

            $this->useMiddleware('kh');

            return redirect('intern/operasional/kh/home/');

        endif;   
    }
}
