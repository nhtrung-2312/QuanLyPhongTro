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
        Schema::table('hopdongthue', function (Blueprint $table) {
            $table->foreign(['MaKhachThue'], 'FK_HopDongThue_KhachThue')->references(['MaKhachThue'])->on('khachthue')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaPhong'], 'FK_HopDongThue_PhongTro')->references(['MaPhong'])->on('phongtro')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hopdongthue', function (Blueprint $table) {
            $table->dropForeign('FK_HopDongThue_KhachThue');
            $table->dropForeign('FK_HopDongThue_PhongTro');
        });
    }
};
