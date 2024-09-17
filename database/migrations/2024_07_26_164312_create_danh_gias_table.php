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
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id();
            $table->string('ma_danh_gia', 10)->unique();
            $table->integer('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('chi_tiet_don_hang_id')->references('id')->on('chi_tiet_don_hangs')->onDelete('cascade');
            $table->integer('sao');
            $table->text('noi_dung');
            $table->date('ngay_danh_gia')->default(Carbon::now());
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['san_pham_id', 'user_id', 'chi_tiet_don_hang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};