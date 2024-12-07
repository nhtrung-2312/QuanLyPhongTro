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
        Schema::create('loaiphong', function (Blueprint $table) {
            $table->string('MaLoaiPhong', 10)->primary();
            $table->integer('DienTich');
            $table->string('LoaiPhong', 20);
            $table->integer('SoNguoi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loaiphong');
    }
};
