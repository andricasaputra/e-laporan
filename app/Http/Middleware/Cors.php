<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header->set("Access-Control-Allow-Origin", "*")
            ->header->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
            ->header->set("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
}