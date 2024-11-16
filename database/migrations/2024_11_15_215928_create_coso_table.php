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
        Schema::create('coso', function (Blueprint $table) {
            $table->string('MaCoSo', 10)->primary();
            $table->string('TenCoSo', 100);
            $table->string('DiaChi', 200);
            $table->string('SDT', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coso');
    }
};
