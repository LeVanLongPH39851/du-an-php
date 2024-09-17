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
        Schema::create('chi_tiet_gio_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_chi_tiet_gio_hang', 10)->unique();
            $table->integer("gio_hang_id")->references('id')->on('gio_hangs')->onDelete('cascade');
            $table->integer("san_pham_id")->nullable();
            $table->integer("bien_the_san_pham_id")->nullable();
            $table->integer("so_luong");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_gio_hangs');
    }
};