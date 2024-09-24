@component('mail::message')

Dear {{ $order->name }},

We have received your order with reference ID {{ $order->unique_order_id }}.. Your certificate will be processed in 2 working days and you will receive your certificate within 7 working days.

@component('mail::button', ['url' => config('app.url')])
View Order
@endcomponent

For any enquiries, kindly email us at sijil@mpm.edu.my.

Thank you.

Regards,<br>
{{ config('app.name') }}
@endcomponent
