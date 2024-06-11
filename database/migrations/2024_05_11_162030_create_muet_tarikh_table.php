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
        Schema::create('muet_tarikh', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('sidang');
            $table->string('tarikh_isu');
            $table->string('tarikh_exp');
            $table->string('sesi');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muet_tarikh');
    }
};
