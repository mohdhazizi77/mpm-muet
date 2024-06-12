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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id'); //from order
            $table->timestamp('payment_date')->nullable(); // get from return URL txn_time
            $table->string('method')->nuallable();// get from return URL type
            $table->float('amount')->nuallable(); // get from return URL amount
            $table->string('status')->default('PENDING'); // get from return URL status
            $table->string('txn_id')->nullable(); //get from return URL txn_id
            $table->string('ref_no')->unique()->nullable(); //get from return URL once create payment url
            $table->text('cust_info')->nuallable(); // get from  return url serialize full_name,email,phone,nric,extra_data['type']
            $table->string('receipt')->nullable(); //get from return URL once create payment url
            $table->string('receipt_number')->nullable(); //get from return URL once create payment url
            $table->string('error_message')->nullable();
            $table->string('payment_for')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('payment_date');
            $table->index('status');
            $table->index('txn_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
