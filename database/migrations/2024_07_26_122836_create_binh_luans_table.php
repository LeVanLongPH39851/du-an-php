<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('binh_luans', function (Blueprint $table) {
            $table->id();
            $table->string('ma_binh_luan', 10)->unique();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
            $table->text('noi_dung');
            $table->dateTime('thoi_gian')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binh_luans');
    }
};