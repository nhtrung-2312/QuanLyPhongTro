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
        Schema::table('nhanvien', function (Blueprint $table) {
            $table->foreign(['MaTaiKhoan'], 'nhanvien_ibfk_1')->references(['MaTaiKhoan'])->on('taikhoan')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['MaCoSo'], 'nhanvien_ibfk_2')->references(['MaCoSo'])->on('coso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nhanvien', function (Blueprint $table) {
            $table->dropForeign('nhanvien_ibfk_1');
            $table->dropForeign('nhanvien_ibfk_2');
        });
    }
};
