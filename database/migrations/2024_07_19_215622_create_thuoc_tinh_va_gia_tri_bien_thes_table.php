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
        Schema::create('thuoc_tinh_va_gia_tri_bien_thes', function (Blueprint $table) {
            $table->id();
            $table->string("ma_thuoc_tinh_va_gia_tri", 10)->unique();
            $table->integer('thuoc_tinh_bien_the_id')->references('id')->on('thuoc_tinh_bien_thes')->onDelete('cascade');
            $table->integer('gia_tri_thuoc_tinh_bien_the_id')->references('id')->on('gia_tri_thuoc_tinh_bien_thes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thuoc_tinh_va_gia_tri_bien_thes');
    }
};