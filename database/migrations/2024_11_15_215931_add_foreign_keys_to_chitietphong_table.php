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
        Schema::table('chitietphong', function (Blueprint $table) {
            $table->foreign(['MaPhong'], 'FK_ChiTietPhong_PhongTro')->references(['MaPhong'])->on('phongtro')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaTienNghi'], 'FK_ChiTietPhong_TienNghi')->references(['MaTienNghi'])->on('tiennghi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitietphong', function (Blueprint $table) {
            $table->dropForeign('FK_ChiTietPhong_PhongTro');
            $table->dropForeign('FK_ChiTietPhong_TienNghi');
        });
    }
};
