<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Payment;

class ProcessPendingOrdersCommand extends Command
{
    protected $signature = 'mpm:process-pending-orders';

    protected $description = 'Process pending orders that have passed 5 minutes since creation';

    public function handle()
    {
        $ordersToUpdate = Order::where('payment_status', 'PENDING')
            ->where('created_at', '<=', now()->subMinutes(5))
            ->get();

        $url = 'https://ebayar-lab.mpm.edu.my/api/payment/status';
        $token = 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem';
        $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';
        
        foreach ($ordersToUpdate as $order) {
            // $order->update(['payment_status' => 'FAILED']);

            $data = [
                "ref_no" => $order->payment_ref_no,
            ];

            $output = '';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'MPMToken: ' . $token
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($curl);
            $output = json_decode($output);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                var_dump($error_msg);
                exit();
            }

            if (!empty($output->data)) {
                curl_close($curl);
                $order->update(['payment_status' => $output->data->txn_status]);

                if ($output->data->txn_status == "SUCCESS") {
                    print_r($output->data);
                    $payment = new Payment();
                    $payment->order_id = $order->id;
                    $payment->payment_date = $output->data->txn_time;
                    $payment->method = $output->data->payment_provider;
                    $payment->amount = $output->data->txn_final_amount;
                    $payment->status = $output->data->txn_status;
                    $payment->txn_id = $output->data->txn_id;
                    $payment->ref_no = $output->data->ref_no;
                    $payment->cust_info = serialize(array("full_name"=>$output->data->full_name, "email"=>$output->data->email_address, "phoneNum"=>$output->data->phone_number));
                    $payment->receipt = $output->data->receipt_url;
                    $payment->receipt_number = $output->data->receipt_no;
                    $payment->error_message = "";
                    $payment->payment_for = $order->payment_for;
                    $payment->type = $order->type;
                    $payment->save();

                }
                // print_r($output->data->txn_status) . "\n";
            } else {
                echo "Payment Gateway tidak dapat disambung. Pastikan URL dan TOKEN adalah betul.";
                curl_close($curl);
            }
        }

        $this->info('Processed ' . count($ordersToUpdate) . ' pending orders.');
    }
}
