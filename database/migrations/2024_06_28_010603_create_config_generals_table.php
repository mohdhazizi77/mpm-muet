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
        Schema::create('config_generals', function (Blueprint $table) {
            $table->id();
            $table->float('rate_mpmprint');
            $table->float('rate_selfprint');
            $table->string('email_alert_order');
            $table->string('mpmbayar_url');
            $table->string('mpmbayar_token');
            $table->string('mpmbayar_secret_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_generals');
    }
};
