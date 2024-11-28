<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotificationSelfPrint extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $env = config('app.env');
        if ($env == 'production') {
            $subject = 'Transaction Confirmed - MPM MUET Certificate Online System';
        } else {
            $subject = '['.strtoupper($env).']'.' Transaction Confirmed - MPM MUET Certificate Online System';
        }
        return (new MailMessage)
                    ->subject($subject)
                    ->markdown('emails.order-confirmed-selfPrint', [
                        'order' => $this->order,
                    ]);

        // return (new MailMessage)
        //             ->greeting('')  // Setting an empty greeting
        //             ->subject('Transaction Confirmed - MPM MUET Certificate Online System')
        //             ->line('Dear '.$this->order->name)
        //             ->line('We have received your payment to view your certificate with reference ID '.$this->order->unique_order_id.'. You can view and download your certificate in 2 days and will expired at '.$this->order->created_at + 2 day)
        //             ->action('View Certificate', config('app.url'))
        //             ->line('For any enquiries, kindly email us at sijil@mpm.edu.my.')
        //             ->line('Thank you.');
    }
}
