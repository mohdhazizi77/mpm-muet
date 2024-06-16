<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $order = new Order();

        $order->unique_order_id = Uuid::uuid4()->toString();
        $order->candidate_id = 1;
        $order->name = 'luqman';
        $order->email = 'luqman@gmail.com';
        $order->phone_num = '0123456789';
        // $order->shipping_address = 'jalan kolam air';
        $order->type = "MUET";
        $order->payment_for = 'SELF_PRINT'; //SELF_PRINT, MPM_PRINT
        $order->payment_status = 'PENDING';
        $order->current_status = 'PENDING';
        $order->courier_id = 1;
        // $order->certificate_id = 42;
        $order->muet_calon_id = 1;
        $order->mod_calon_id = 1;

        $order->save();

        for ($i=1; $i < 40; $i++) {
            $faker = Faker::create();

            $type = ['MUET', 'MOD'];
            $payment_for = ['SELF_PRINT', 'MPM_PRINT'];
            $payment_status = ['PENDING', 'SUCCESS', 'FAILED'];
            // $current_status = ['PAID', 'NEW', 'PROCESSING', 'COMPLETE' , 'CANCELED', 'FAILED'];

            $order = new Order();
            $order->unique_order_id = Uuid::uuid4()->toString();
            $order->candidate_id = $i+1;
            $order->name = $faker->name;
            $order->email = $faker->email;
            $order->phone_num = $faker->phoneNumber;
            // $order->shipping_address = $faker->address;
            $order->type = $type[array_rand($type)]; //MUET, MOD
            $order->payment_for = $payment_for[array_rand($payment_for)]; //SELF_PRINT, MPM_PRINT
            $order->payment_status = $payment_status[array_rand($payment_status)]; //'PENDING', 'SUCCESS', 'FAILED';
            if ($order->payment_status == "FAILED") {
                $sts = "FAILED";
            } elseif ($order->payment_status == "PENDING") {
                $sts = "PENDING";
            } else {

                if ($order->payment_for == "SELF_PRINT") {
                    $sts = "PAID";
                } else { //MPM_PRINT
                    $sts = "NEW";
                }

            }
            $order->current_status = $sts; //'PAID', 'NEW', 'PROCESSING', 'COMPLETE' , 'CANCEL', 'FAIL';
            $order->courier_id = 1;
            $order->muet_calon_id = 1;
            $order->mod_calon_id = 1;

            $order->save();
        }
    }
}
