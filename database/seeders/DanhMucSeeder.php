<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('danh_mucs')->insert([
            [
            'ma_danh_muc' => "DM-".Str::random(6),
            'ten_danh_muc' => 'Iphone',
            'ngay_nhap' => Carbon::now(), //Lấy ngày
            'trang_thai' => 1, //Lấy ngày
            ],
            [
            'ma_danh_muc' => "DM-".Str::random(6),
            'ten_danh_muc' => 'SamSung',
            'ngay_nhap' => Carbon::now(), //Lấy ngày
            'trang_thai' => 1,
            ]
    ]);
    }
}