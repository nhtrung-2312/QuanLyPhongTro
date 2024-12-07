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
        Schema::table('chitiethopdong', function (Blueprint $table) {
            $table->foreign(['MaHopDong'], 'chitiethopdong_ibfk_1')->references(['MaHopDong'])->on('hopdongthue')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaKhachThue'], 'chitiethopdong_ibfk_2')->references(['MaKhachThue'])->on('khachthue')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitiethopdong', function (Blueprint $table) {
            $table->dropForeign('chitiethopdong_ibfk_1');
            $table->dropForeign('chitiethopdong_ibfk_2');
        });
    }
};
