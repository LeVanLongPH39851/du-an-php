<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang', 10)->unique();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ten_nguoi_nhan', 100);
            $table->string('email_nguoi_nhan', 100);
            $table->string('so_dien_thoai_nguoi_nhan', 100);
            $table->string('dia_chi_nguoi_nhan', 100);
            $table->date("ngay_dat")->default(Carbon::now());
            $table->integer('tong_tien');
            $table->string('ghi_chu', 100)->nullable();
            $table->integer('phuong_thuc_thanh_toan_id')->references('id')->on('phuong_thuc_thanh_toans')->onDelete('cascade');
            $table->integer('trang_thai_don_hang_id')->references('id')->on('trang_thai_don_hangs')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};