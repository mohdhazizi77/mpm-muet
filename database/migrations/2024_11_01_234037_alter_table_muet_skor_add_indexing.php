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
        Schema::table('muet_skor', function (Blueprint $table) {
            $table->index('tahun');
            $table->index('sidang');
            $table->index('kodnegeri');
            $table->index('kodpusat');
            $table->index('jcalon');
            $table->index('nocalon');
            $table->index('kodkts');
            $table->index('mkhbaru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('muet_skor', function (Blueprint $table) {
            $table->dropIndex(['tahun']);
            $table->dropIndex(['sidang']);
            $table->dropIndex(['kodnegeri']);
            $table->dropIndex(['kodpusat']);
            $table->dropIndex(['jcalon']);
            $table->dropIndex(['nocalon']);
            $table->dropIndex(['kodkts']);
            $table->dropIndex(['mkhbaru']);
        });
    }
};