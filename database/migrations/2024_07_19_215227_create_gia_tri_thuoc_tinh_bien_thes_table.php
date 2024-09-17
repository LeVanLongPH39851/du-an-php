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
        Schema::create('gia_tri_thuoc_tinh_bien_thes', function (Blueprint $table) {
            $table->id();
            $table->string('ma_gia_tri_thuoc_tinh_bt', 10)->unique();
            $table->string('ten_gia_tri_thuoc_tinh_bt', 100);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gia_tri_thuoc_tinh_bien_thes');
    }
};