<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->headers->set("Access-Control-Allow-Origin", "*")
            ->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
            ->headers->set("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
}