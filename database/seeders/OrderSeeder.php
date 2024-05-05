<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use Ramsey\Uuid\Uuid;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $order = new Order();

        $order->unique_order_id = Uuid::uuid4()->toString();
        $order->user_id = 46;
        $order->name = 'luqman';
        $order->email = 'luqman@gmail.com';
        $order->phone_num = '0123456789';
        $order->shipping_address = 'jalan kolam air';
        $order->payment_for = 'SELF_PRINT'; //SELF_PRINT, MPM_PRINT
        $order->payment_status = 'PENDING';
        $order->courier_id = 1;
        $order->certificate_id = 42;

        $order->save();
    }
}
