<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id();
            $table->string("ma_chi_tiet_don_hang", 10)->unique();
            $table->integer('don_hang_id')->references('id')->on('don_hangs')->onDelete('cascade');
            $table->integer('san_pham_id')->nullable();
            $table->integer('bien_the_san_pham_id')->nullable();
            $table->integer('so_luong');
            $table->integer('gia');
            $table->integer('thanh_tien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};