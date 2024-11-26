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
        Schema::table('khachthue', function (Blueprint $table) {
            $table->foreign(['MaTaiKhoan'], 'khachthue_ibfk_1')->references(['MaTaiKhoan'])->on('taikhoan')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('khachthue', function (Blueprint $table) {
            $table->dropForeign('khachthue_ibfk_1');
        });
    }
};
