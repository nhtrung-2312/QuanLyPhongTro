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
        Schema::table('chitiethoadon', function (Blueprint $table) {
            $table->foreign(['MaHoaDon'], 'FK_ChiTietHoaDon_HoaDon')->references(['MaHoaDon'])->on('hoadon')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaLoaiPhi'], 'FK_ChiTietHoaDon_LoaiPhi')->references(['MaLoaiPhi'])->on('loaiphi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitiethoadon', function (Blueprint $table) {
            $table->dropForeign('FK_ChiTietHoaDon_HoaDon');
            $table->dropForeign('FK_ChiTietHoaDon_LoaiPhi');
        });
    }
};
