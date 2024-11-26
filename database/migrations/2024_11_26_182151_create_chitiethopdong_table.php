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
        Schema::create('chitiethopdong', function (Blueprint $table) {
            $table->string('MaHopDong', 10);
            $table->string('MaKhachThue', 10)->index('makhachthue');

            $table->primary(['MaHopDong', 'MaKhachThue']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiethopdong');
    }
};
