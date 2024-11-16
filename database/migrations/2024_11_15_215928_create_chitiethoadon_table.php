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
        Schema::create('chitiethoadon', function (Blueprint $table) {
            $table->string('MaChiTietHD', 10)->primary();
            $table->string('MaHoaDon', 10)->index('fk_chitiethoadon_hoadon');
            $table->string('MaLoaiPhi', 10)->index('fk_chitiethoadon_loaiphi');
            $table->integer('SoLuong')->nullable();
            $table->decimal('ThanhTien', 10);
            $table->string('GhiChu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiethoadon');
    }
};
