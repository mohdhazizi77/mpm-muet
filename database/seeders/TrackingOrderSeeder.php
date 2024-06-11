<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TrackingOrder;
use App\Models\Order;
use App\Models\Payment;

use Ramsey\Uuid\Uuid;


class TrackingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // TrackingOrder::truncate();
        // Payment::truncate();

        // $track = new TrackingOrder ();
        // $track->order_id = 1;
        // $track->detail = 'Payment made';
        // $track->status = 'PAID';
        // $track->save();

        // $track = new TrackingOrder ();
        // $track->order_id = 1;
        // $track->detail = 'Admin received order';
        // $track->status = 'NEW';
        // $track->save();

        // $orders = Order::all();

        // foreach ($orders as $key => $order) {
        //     if ($order->payment_status == 'SUCCESS') {

        //         $pay = new Payment ();
        //         $pay->order_id = $order->id;
        //         $pay->payment_date = date("Y-m-d H:i:s");
        //         $pay->method = "FPX";
        //         $pay->amount = $order->payment_for == "SELF_PRINT" ? 20.00 : 60.00;
        //         $pay->status = "SUCCESS";
        //         $pay->txn_id = Uuid::uuid4()->toString();
        //         $pay->ref_no = Uuid::uuid4()->toString();
        //         $pay->error_message = "";
        //         $pay->cust_info = json_encode(array('name'=>$order->name,'email'=>$order->email,'phoneNum'=>$order->phone_num,'ship_addr'=>$order->shipping_address));
        //         $pay->save();

        //         if ($order->payment_for == 'MPM_PRINT') {

        //             $track = new TrackingOrder();
        //             $track->order_id = $order->id;
        //             $track->detail = 'Payment made';
        //             $track->status = 'PAID';
        //             $track->save();

        //             $track = new TrackingOrder();
        //             $track->order_id = $order->id;
        //             $track->detail = 'Admin received order';
        //             $track->status = 'NEW';
        //             $track->save();
        //         } elseif($order->payment_for == 'SELF_PRINT'){

        //             $track = new TrackingOrder();
        //             $track->order_id = $order->id;
        //             $track->detail = 'Payment made';
        //             $track->status = 'PAID';
        //             $track->save();
        //         }


        //     }
        // }
    }
}
