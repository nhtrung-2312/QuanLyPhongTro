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
        Schema::create('thanhtoan', function (Blueprint $table) {
            $table->string('MaThanhToan', 10)->primary();
            $table->string('MaHoaDon', 10)->index('fk_thanhtoan_hoadon');
            $table->dateTime('NgayThanhToan')->useCurrent();
            $table->decimal('SoTien', 10);
            $table->string('PhuongThucThanhToan', 50);
            $table->string('GhiChu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanhtoan');
    }
};
