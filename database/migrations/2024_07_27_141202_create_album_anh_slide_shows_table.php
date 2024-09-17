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
        Schema::create('album_anh_slide_shows', function (Blueprint $table) {
            $table->id();
            $table->string('ma_album_anh_slide_show', 10)->unique();
            $table->text('duong_dan_anh');
            $table->string('link')->nullable();
            $table->integer('order')->default(0);
            $table->integer('slide_show_id')->references('id')->on('slide_shows')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_anh_slide_shows');
    }
};