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
        Schema::table('phongtro', function (Blueprint $table) {
            $table->foreign(['MaCoSo'], 'phongtro_ibfk_1')->references(['MaCoSo'])->on('coso')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaLoaiPhong'], 'phongtro_ibfk_2')->references(['MaLoaiPhong'])->on('loaiphong')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phongtro', function (Blueprint $table) {
            $table->dropForeign('phongtro_ibfk_1');
            $table->dropForeign('phongtro_ibfk_2');
        });
    }
};
