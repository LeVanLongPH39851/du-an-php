<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdatePromotionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::now()->startOfDay();
        
        SanPham::whereNotNull('gia_khuyen_mai')  // Kiểm tra 'gia_khuyen_mai' không phải NULL
        ->whereNotNull('ngay_ket_thuc_km')  // Kiểm tra 'ngay_ket_thuc_km' không phải NULL
        ->where('ngay_ket_thuc_km', '<', $today)  // Ngày kết thúc khuyến mãi trước ngày hiện tại
        ->update([
            'gia_khuyen_mai' => null,
            'ngay_ket_thuc_km' => null,
        ]);
        return $next($request);
    }
}