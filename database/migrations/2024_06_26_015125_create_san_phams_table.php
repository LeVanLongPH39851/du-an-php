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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ma_san_pham', 10)->unique(); //unique quy định dữ liệu không được trùng nhau
            $table->string('ten_san_pham', 100);
            $table->text('anh_san_pham')->nullable();
            $table->integer('gia');
            $table->integer('so_luong'); //Cho phép giá trị là null
            $table->text('mo_ta')->nullable();
            $table->date('ngay_nhap')->default(Carbon::now()); //Kiểu ngày tháng năm
            $table->integer('danh_muc_id')->references('id')->on('danh_mucs')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};