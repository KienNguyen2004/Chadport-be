<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class JwtFromCookie
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
        // Kiểm tra nếu cookie 'jwt_token' tồn tại
        if ($request->cookie('jwt_token')) {
            // Đặt token vào header 'Authorization' để `auth:api` có thể đọc được
            $request->headers->set('Authorization', 'Bearer ' . $request->cookie('jwt_token'));
        }

        return $next($request);
    }
}
