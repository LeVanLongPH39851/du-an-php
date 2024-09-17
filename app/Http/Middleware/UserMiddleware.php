<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == false) {
            // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập với thông báo lỗi
            return redirect()->route('client.form.login')->with('error', 'Vui lòng đăng nhập');
        }
        return $next($request);
    }
}