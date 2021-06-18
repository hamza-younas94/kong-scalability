<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Http\Request;
use JWTAuth;

class JWTMiddleWare extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
