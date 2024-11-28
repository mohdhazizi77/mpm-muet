@component('mail::message')
Dear {{ $order->name }},

We have received your payment to view your certificate with reference ID {{ $order->unique_order_id }}. You can view and download your certificate in 2 days and will <b>expire at {{ $order->created_at->addDays(2)->format('d/m/Y H:i:s') }}</b> .

@component('mail::button', ['url' => config('app.url')])
View Certificate
@endcomponent

For any enquiries, kindly email us at sijil@mpm.edu.my.

Thank you.

Regards,<br>
{{ config('app.name') }}
@endcomponent
