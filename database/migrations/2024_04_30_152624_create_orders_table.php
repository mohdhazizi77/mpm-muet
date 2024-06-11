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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('unique_order_id');
            $table->string('payment_ref_no')->nullable();
            $table->integer('candidate_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_num');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('payment_for');
            $table->string('type');
            $table->string('payment_status')->default('PENDING')->nullable();
            $table->string('current_status')->default('NEW')->nullable();
            $table->string('courier_id')->nullable();
            $table->string('muet_calon_id')->nullable();
            $table->string('mod_calon_id')->nullable();
            $table->string('tracking_number')->nullable();

            $table->timestamps();

            $table->index('courier_id');
            $table->index('payment_ref_no');
            $table->index('unique_order_id');
            $table->index('payment_for');
            $table->index('type');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
