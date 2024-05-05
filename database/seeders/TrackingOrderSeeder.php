<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TrackingOrder;


class TrackingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $track = new TrackingOrder ();
        $track->order_id = 1;
        $track->detail = 'Payment made';
        $track->status = 'PAID';
        $track->save();

        $track = new TrackingOrder ();
        $track->order_id = 1;
        $track->detail = 'Admin received order';
        $track->status = 'NEW';
        $track->save();
    }
}
