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
        Schema::create('chitietphong', function (Blueprint $table) {
            $table->string('MaPhong', 10);
            $table->string('MaTienNghi', 10)->index('fk_chitietphong_tiennghi');
            $table->integer('SoLuong')->default(1);
            $table->string('TinhTrang', 50)->nullable()->default('Tốt');
            $table->string('GhiChu')->nullable();

            $table->primary(['MaPhong', 'MaTienNghi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitietphong');
    }
};
