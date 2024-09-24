<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification
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
                    ->markdown('emails.order-confirmed', [
                        'order' => $this->order,
                    ]);

        return (new MailMessage)
                    ->greeting('')  // Setting an empty greeting
                    ->subject('Transaction Confirmed - MPM MUET Certificate Online System')
                    ->line('Dear '.$this->order->name)
                    ->line('We have received your order with reference ID '.$this->order->unique_order_id.'. Your certificate will be processed in 2 working days and you will receive your certificate within 7 working days.')
                    ->action('View Order', config('app.url'))
                    ->line('For any enquiries, kindly email us at sijil@mpm.edu.my.')
                    ->line('Thank you.');
    }
}
