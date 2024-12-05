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
            $table->foreign(['MaPhong'], 'chitietphong_ibfk_1')->references(['MaPhong'])->on('phongtro')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaTienNghi'], 'chitietphong_ibfk_2')->references(['MaTienNghi'])->on('tiennghi')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaPhong'], 'chitietphong_ibfk_3')->references(['MaPhong'])->on('phongtro')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaTienNghi'], 'chitietphong_ibfk_4')->references(['MaTienNghi'])->on('tiennghi')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitietphong', function (Blueprint $table) {
            $table->dropForeign('chitietphong_ibfk_1');
            $table->dropForeign('chitietphong_ibfk_2');
            $table->dropForeign('chitietphong_ibfk_3');
            $table->dropForeign('chitietphong_ibfk_4');
        });
    }
};
