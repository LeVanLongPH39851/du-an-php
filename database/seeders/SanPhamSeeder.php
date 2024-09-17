<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; //Sử dụng thư viện bên ngoài
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; //Sử dụng thư viện bên ngoài

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Thêm dữ liệu mẫu
        // DB::table('tên_bảng')->các phương thức();
        DB::table('san_phams')->insert([
            [
            'ma_san_pham' => "SP-".Str::random(6),
            'ten_san_pham' => 'Iphone 15',
            'gia' => 16000000,
            'so_luong' => 100,
            'mo_ta' => "Iphone 15 chính hãng",
            'ngay_nhap' => Carbon::now(),
            'trang_thai' => 1,
            'danh_muc_id' => 1,
        ],
        [
            'ma_san_pham' => "SP-".Str::random(6),
            'ten_san_pham' => 'Iphone 14',
            'gia' => 14000000,
            'so_luong' => 60,
            'mo_ta' => "Iphone 14 chính hãng",
            'ngay_nhap' => Carbon::now(),
            'trang_thai' => 1,
            'danh_muc_id' => 1,
        ]]);
    }
}