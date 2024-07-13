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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identity_card_number')->unique();
            $table->string('password');
            $table->integer('retry_verify_index_number')->default(0);
            $table->timestamp('date_verify_index_number')->default(date('Y-m-d H:i:s'));
            $table->integer('is_deleted')->default(0);
            $table->timestamps();

            $table->index('identity_card_number');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
