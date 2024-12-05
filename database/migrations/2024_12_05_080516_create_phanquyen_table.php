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
        Schema::create('phanquyen', function (Blueprint $table) {
            $table->string('MaTaiKhoan', 10);
            $table->string('MaQuyen', 10)->index('fk_phanquyen_maquyen');
            $table->string('MaCoSo', 10)->index('fk_phanquyen_macoso');

            $table->primary(['MaTaiKhoan', 'MaQuyen', 'MaCoSo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phanquyen');
    }
};
