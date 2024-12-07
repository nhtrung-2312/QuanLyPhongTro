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
            $table->foreign(['MaHopDong'], 'hoadon_ibfk_1')->references(['MaHopDong'])->on('hopdongthue')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaChiSo'], 'hoadon_ibfk_2')->references(['MaChiSo'])->on('chisodiennuoc')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropForeign('hoadon_ibfk_1');
            $table->dropForeign('hoadon_ibfk_2');
        });
    }
};
