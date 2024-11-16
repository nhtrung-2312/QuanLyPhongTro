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
            $table->string('TenDangNhap', 50)->primary();
            $table->string('MatKhau', 100);
            $table->string('MaNhanVien', 10)->index('fk_taikhoan_nhanvien');
            $table->string('VaiTro', 20)->default('Nhân viên');
            $table->boolean('TrangThai')->default(false);
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
