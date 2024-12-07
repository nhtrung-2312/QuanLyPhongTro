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
        Schema::table('chisodiennuoc', function (Blueprint $table) {
            $table->foreign(['MaPhong'], 'chisodiennuoc_ibfk_1')->references(['MaPhong'])->on('phongtro')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chisodiennuoc', function (Blueprint $table) {
            $table->dropForeign('chisodiennuoc_ibfk_1');
        });
    }
};