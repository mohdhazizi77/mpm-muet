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
        Schema::create('mod_calon', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('sidang');
            $table->string('nama');
            $table->string('kp');
            $table->string('kodnegeri');
            $table->string('kodpusat');
            $table->string('nocalon');
            $table->string('reg_id');
            $table->string('alamat1');
            $table->string('alamat2')->nullable();
            $table->string('alamat3')->nullable();
            $table->string('poskod');
            $table->string('bandar');
            $table->string('negeri');
            $table->string('skor_agregat');
            $table->string('band');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mod_calon');
    }
};
