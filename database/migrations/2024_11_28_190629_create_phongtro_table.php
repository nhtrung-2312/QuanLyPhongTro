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
        Schema::create('phongtro', function (Blueprint $table) {
            $table->string('MaPhong', 10)->primary();
            $table->string('MaCoSo', 10)->nullable()->index('macoso');
            $table->string('MaLoaiPhong', 10)->index('maloaiphong')->default("");
            $table->string('TenPhong', 50);
            $table->decimal('GiaThue', 10);
            $table->string('TrangThai', 20)->default('Trống');
            $table->string('MoTa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phongtro');
    }
};
