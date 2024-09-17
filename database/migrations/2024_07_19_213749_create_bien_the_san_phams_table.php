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
        Schema::create('bien_the_san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ma_bien_the_san_pham', 10)->unique();
            $table->text('anh_bien_the_san_pham')->nullable();
            $table->integer('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
            $table->integer('gia');
            $table->integer('so_luong');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien_the_san_phams');
    }
};