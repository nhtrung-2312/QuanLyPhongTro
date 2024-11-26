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
            $table->foreign(['MaHoaDon'], 'chitiethoadon_ibfk_1')->references(['MaHoaDon'])->on('hoadon')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaLoaiPhi'], 'chitiethoadon_ibfk_2')->references(['MaLoaiPhi'])->on('loaiphi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitiethoadon', function (Blueprint $table) {
            $table->dropForeign('chitiethoadon_ibfk_1');
            $table->dropForeign('chitiethoadon_ibfk_2');
        });
    }
};
