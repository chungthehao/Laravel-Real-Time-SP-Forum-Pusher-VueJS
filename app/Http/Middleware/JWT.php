<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWT
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
        // - Có vấn đề gì thì nó sẽ throw errors, mình đã rào trước cái trường hợp của nó
        // trong file Handler.php
        JWTAuth::parseToken()->authenticate();

        return $next($request);
    }
}
