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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("ma_khach_hang", 10)->unique();
            $table->string('name');
            $table->string("so_dien_thoai", 50);
            $table->string('email')->unique();
            $table->string("dia_chi", 100);
            $table->text("anh_dai_dien")->nullable();
            $table->integer("vai_tro")->default(1);
            $table->date("ngay_tao")->default(Carbon::now());
            $table->string("mat_khau", 100);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};