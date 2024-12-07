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
        Schema::table('thanhtoan', function (Blueprint $table) {
            $table->foreign(['MaHoaDon'], 'thanhtoan_ibfk_1')->references(['MaHoaDon'])->on('hoadon')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thanhtoan', function (Blueprint $table) {
            $table->dropForeign('thanhtoan_ibfk_1');
        });
    }
};
