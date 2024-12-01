<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ConfigMpmBayar;
use App\Models\ConfigPoslaju;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class ProcessCompletedOrdersCommand extends Command
{
    protected $signature = 'mpm:process-completed-orders';

    protected $description = 'Process completed orders that have passed 2 days and with pos status and delivery success';

    public function handle()
    {
        $ordersToUpdate = Order::where('current_status', 'COMPLETED')
            ->whereNotNull('tracking_number')
            ->get();

        $this->info( count($ordersToUpdate) . ' of completed orders.');

        $culture = 'EN';
        // ConfigPoslaju::getToken(); //store token into session
        $bearerToken = ConfigPoslaju::getToken();

        $ConfigPoslaju = ConfigPoslaju::first();

        $count = 0;
        foreach ($ordersToUpdate as $order) {

            $response = Http::withToken($bearerToken)
                            ->get($ConfigPoslaju->url . '/as2corporate/v2trackntracewebapijson/v1/api/Details', [
                                'id' => $order->tracking_number,
                                'Culture' => $culture,
                            ]);

            if ($response->successful()) {
                $data = [];
                $response = json_decode($response->getBody()->getContents());
                foreach ($response as $key => $value) {

                    if ($value->process == "Delivery Success") {

                        $order->current_status = "DELIVERED";
                        $order->save();

                        $count++;
                    }
                }

            }

        }

        $this->info('Processed ' . count($ordersToUpdate) . ' completed orders.');
    }
}
