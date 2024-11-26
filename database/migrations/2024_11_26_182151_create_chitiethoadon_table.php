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
            $table->string('MaHoaDon', 10);
            $table->string('MaLoaiPhi', 10)->index('maloaiphi');
            $table->integer('SoLuong')->nullable();
            $table->decimal('ThanhTien', 10);
            $table->string('GhiChu')->nullable();

            $table->primary(['MaHoaDon', 'MaLoaiPhi']);
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
