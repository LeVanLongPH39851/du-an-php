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
        Schema::create('thuoc_tinh_bien_thes', function (Blueprint $table) {
            $table->id();
            $table->string('ma_thuoc_tinh_bien_the', 10)->unique();
            $table->string('ten_thuoc_tinh_bien_the', 100);
            $table->integer('bien_the_san_pham_id')->references('id')->on('bien_the_san_phams')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thuoc_tinh_bien_thes');
    }
};