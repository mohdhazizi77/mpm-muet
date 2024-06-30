<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompletedNotification extends Notification
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
     * @return array<int, string>
     */
    public function via(object $notifiable): array
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
        return (new MailMessage)
                    ->greeting('')  // Setting an empty greeting
                    ->subject('Transaction Completed - MPM MUET Certificate Online System')
                    ->line('Dear '.$this->order->name)
                    ->line('We have received your order with reference ID '.$this->order->unique_order_id.' has been completed and shipped. You will receive your certificate within 7 working days.')
                    ->line('You may check your order via web portal > Check Order History. Alternatively, you may key in this tracking number '.$this->order->tracking_number.' via Poslaju Portal')
                    ->action('View Order', config('app.url'))
                    ->line('For any enquiries, kindly email us at sijil@mpm.edu.my.')
                    ->line('Thank you.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
