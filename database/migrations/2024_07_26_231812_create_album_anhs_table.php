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
        Schema::create('album_anhs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_album_anh', 10)->unique();
            $table->text('duong_dan_anh');
            $table->integer('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_anhs');
    }
};