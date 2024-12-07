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
        Schema::table('phanquyen', function (Blueprint $table) {
            $table->foreign(['MaQuyen'], 'fk_phanquyen_maquyen')->references(['MaQuyen'])->on('quyen')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaCoSo'], 'fk_phanquyen_maso')->references(['MaCoSo'])->on('coso')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaTaiKhoan'], 'fk_phanquyen_matk')->references(['MaTaiKhoan'])->on('taikhoan')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phanquyen', function (Blueprint $table) {
            $table->dropForeign('fk_phanquyen_maquyen');
            $table->dropForeign('fk_phanquyen_maso');
            $table->dropForeign('fk_phanquyen_matk');
        });
    }
};
