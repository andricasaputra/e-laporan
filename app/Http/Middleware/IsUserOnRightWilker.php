<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUserOnRightWilker
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
        // if(Auth::user()){

        //     $wilker = Auth::user()->wilker()->get()->pluck('id');

        //     foreach ($wilker as $key => $value) {

                
               
        //     }

        //     return $next($request);

        //     dd($request);

        // }

        // return back();
        
    }
}
