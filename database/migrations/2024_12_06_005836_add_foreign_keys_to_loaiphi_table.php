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
        Schema::table('loaiphi', function (Blueprint $table) {
            $table->foreign(['MaCoSo'], 'fk_loaiphi_macoso')->references(['MaCoSo'])->on('coso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loaiphi', function (Blueprint $table) {
            $table->dropForeign('fk_loaiphi_macoso');
        });
    }
};
