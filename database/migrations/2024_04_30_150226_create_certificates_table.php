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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('index_number')->unique();
            $table->string('cid')->nullable();
            $table->integer('exam_session_id');
            $table->text('result');
            $table->timestamp('issue_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->integer('muet_center_id')->nullable();
            $table->timestamps();

            $table->index('index_number');
            $table->index('exam_session_id');
            $table->index('muet_center_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
