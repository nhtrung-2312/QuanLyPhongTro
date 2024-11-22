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
        Schema::create('loaiphi', function (Blueprint $table) {
            $table->string('MaLoaiPhi', 10)->primary();
            $table->string('TenLoaiPhi', 50);
            $table->decimal('DonGia', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loaiphi');
    }
};
