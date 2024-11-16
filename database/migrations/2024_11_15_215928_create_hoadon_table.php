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
        Schema::create('hoadon', function (Blueprint $table) {
            $table->string('MaHoaDon', 10)->primary();
            $table->string('MaHopDong', 10)->index('fk_hoadon_hopdongthue');
            $table->string('MaChiSo', 10)->index('fk_hoadon_chiso');
            $table->date('NgayLap');
            $table->decimal('TongTien', 10);
            $table->string('TrangThai', 20)->default('Chưa thanh toán');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadon');
    }
};
