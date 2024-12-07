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
        Schema::create('khachthue', function (Blueprint $table) {
            $table->string('MaKhachThue', 10)->primary();
            $table->string('HoTen', 100)->nullable();
            $table->string('CCCD', 12)->nullable()->unique('cccd');
            $table->string('SDT', 10);
            $table->string('DiaChi', 200)->nullable();
            $table->date('NgaySinh')->nullable();
            $table->string('GioiTinh', 10)->nullable();
            $table->string('MaTaiKhoan', 10)->nullable()->index('mataikhoan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khachthue');
    }
};
