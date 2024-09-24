<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigPoslaju extends Model
{
    protected $table = 'config_poslajus';

    protected $fillable = [
        'url',
        'client_id',
        'client_secret',
        'grant_type',
        'scope',

        'Prefix',
        'ApplicationCode',
        'Secretid',
        'username',

        'subscriptionCode',
        'requireToPickup',
        'requireWebHook',
        'accountNo',
        'callerName',
        'callerPhone',
        'pickupLocationID',
        'pickupLocationName',
        'contactPerson',
        'phoneNo',
        'pickupAddress',
        'pickupDistrict',
        'pickupProvince',
        'pickupCountry',
        'pickupEmail',
        'postCode',
        'ItemType',
        'totalQuantityToPickup',
        'PaymentType',
        'readyToCollectAt',
        'closeAt',
        'ShipmentName',
        'currency',
        'countryCode',
    ];

    protected $casts = [
        'requireToPickup' => 'boolean',
        'requireWebHook' => 'boolean',
        'accountNo' => 'integer',
        'postCode' => 'integer',
        'ItemType' => 'integer',
        'totalQuantityToPickup' => 'integer',
    ];
}
