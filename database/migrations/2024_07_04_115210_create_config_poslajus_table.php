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
        Schema::create('config_poslajus', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('grant_type');
            $table->string('scope');

            $table->string('Prefix'); //can use as SecretId
            $table->string('ApplicationCode'); //can use as SecretId
            $table->string('Secretid');
            $table->string('username');

            $table->string('subscriptionCode');
            $table->boolean('requireToPickup')->default(1);
            $table->boolean('requireWebHook')->default(1);
            $table->biginteger('accountNo'); //Master Account that register at POS
            $table->string('callerName'); // Master Account Owner Name
            $table->string('callerPhone'); // Master Account Phone No
            $table->string('pickupLocationID'); // Merchants Unique Register ID
            $table->string('pickupLocationName'); //Merchants Name(Merchant s registered under callerName)
            $table->string('contactPerson'); //Merchants Contact Person Name
            $table->string('phoneNo'); //Merchants Contact Person Phone Number
            $table->string('pickupEmail'); //Merchants Contact Person email
            $table->string('pickupAddress'); // Merchants Address address courier will pick up
            $table->string('pickupDistrict');
            $table->string('pickupProvince');
            $table->string('pickupCountry');
            $table->integer('postCode'); //Pickup postcode Refer List of Postcode Coverage

            $table->integer('ItemType')->default(0); //0 for document
            $table->integer('totalQuantityToPickup')->default(1); //always 1
            $table->string('PaymentType')->default(2); //2 paid
            $table->string('readyToCollectAt'); // time in string 12:00 PM
            $table->string('closeAt'); // time in string 6:00 PM
            $table->string('ShipmentName')->default('PosLaju');
            $table->string('currency')->default('MYR');
            $table->string('countryCode')->default('MY');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_poslajus');
    }
};
