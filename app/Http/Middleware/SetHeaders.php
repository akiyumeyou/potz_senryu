<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Permissions-Policy', "accelerometer=(), autoplay=(), clipboard-write=(), encrypted-media=(), gyroscope=(), picture-in-picture=()");

        return $response;
    }
}

