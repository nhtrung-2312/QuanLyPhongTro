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
        Schema::create('taikhoan', function (Blueprint $table) {
            $table->string('MaTaiKhoan', 10)->primary();
            $table->string('TenDangNhap', 50)->nullable();
            $table->string('MatKhau', 100);
            $table->string('VaiTro', 20)->default('Khách hàng');
            $table->boolean('TrangThai')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taikhoan');
    }
};
