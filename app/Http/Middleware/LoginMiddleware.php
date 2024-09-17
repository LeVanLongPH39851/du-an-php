<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
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
            return redirect()->route('login')->with('error', 'Bạn chưa đăng nhập');
        }
        else if (Auth::user()->vai_tro != 2) {
            // Nếu người dùng không phải là admin, chuyển hướng đến trang đăng nhập với thông báo lỗi
            return redirect()->route('login')->with('error', 'Bạn không phải là admin');
        }
        return $next($request);
    }
}