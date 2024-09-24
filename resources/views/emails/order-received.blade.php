@component('mail::message')

Dear MPM Admin

An order with reference ID {{ $order->unique_order_id }} has been received. Kindly complete this transaction within 2 working days.'

Thank you.

Regards,<br>
{{ config('app.name') }}
@endcomponent
