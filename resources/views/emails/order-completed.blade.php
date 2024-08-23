@component('mail::message')

Dear {{ $order->name }},

We have received your order with reference ID {{ $order->unique_order_id }} has been completed and shipped. You will receive your certificate within 7 working days.

You may check your order via web portal > Check Order History. Alternatively, you may key in this tracking number {{ $order->tracking_number }} via Poslaju Portal.

@component('mail::button', ['url' => config('app.url')])
View Order
@endcomponent

For any enquiries, kindly email us at sijil@mpm.edu.my.

Thank you.

Regards,<br>
{{ config('app.name') }}
@endcomponent
