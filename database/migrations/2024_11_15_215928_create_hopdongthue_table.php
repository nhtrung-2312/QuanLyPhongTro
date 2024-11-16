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
        Schema::create('hopdongthue', function (Blueprint $table) {
            $table->string('MaHopDong', 10)->primary();
            $table->string('MaPhong', 10)->index('fk_hopdongthue_phongtro');
            $table->string('MaKhachThue', 10)->index('fk_hopdongthue_khachthue');
            $table->date('NgayBatDau');
            $table->date('NgayKetThuc');
            $table->string('TrangThai', 20)->default('Đang thuê');
            $table->decimal('TienCoc', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopdongthue');
    }
};
