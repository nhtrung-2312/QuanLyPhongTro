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
        Schema::table('hoadon', function (Blueprint $table) {
            $table->foreign(['MaChiSo'], 'FK_HoaDon_ChiSo')->references(['MaChiSo'])->on('chisodiennuoc')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaHopDong'], 'FK_HoaDon_HopDongThue')->references(['MaHopDong'])->on('hopdongthue')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropForeign('FK_HoaDon_ChiSo');
            $table->dropForeign('FK_HoaDon_HopDongThue');
        });
    }
};
