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
        Schema::create('chisodiennuoc', function (Blueprint $table) {
            $table->string('MaChiSo', 10)->primary();
            $table->string('MaPhong', 10)->index('fk_chiso_phong');
            $table->string('Loai', 20);
            $table->integer('ChiSoCu');
            $table->integer('ChiSoMoi');
            $table->date('NgayGhi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chisodiennuoc');
    }
};
