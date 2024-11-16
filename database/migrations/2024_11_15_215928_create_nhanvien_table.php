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
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->string('MaNhanVien', 10)->primary();
            $table->string('HoTen', 100);
            $table->string('CCCD', 12)->unique('uq_cccd_nv');
            $table->string('SDT', 10);
            $table->string('DiaChi', 200);
            $table->date('NgaySinh');
            $table->string('GioiTinh', 10);
            $table->string('ChucVu', 50);
            $table->decimal('Luong', 10);
            $table->string('MaCoSo', 10)->index('fk_nhanvien_coso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhanvien');
    }
};
