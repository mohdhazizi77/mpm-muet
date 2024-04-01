<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cefr_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('session');
            $table->string('agg_score');
            $table->string('band');
            $table->string('cefr_level');
            $table->string('user');
            $table->text('description');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cefr_configs');
    }
};
