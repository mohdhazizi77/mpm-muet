<table>
    <thead>
        <tr>
            <th>#</th>
            <th>TRANSACTION ID</th>
            <th>RECEIPT NO</th>
            <th>TRANSACTION DATE</th>
            <th>CANDIDATE NAME</th>
            <th>AMOUNT (RM)</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->order->unique_order_id ?? 'no record' }}</td>
                <td>{{ $payment->receipt_number  ?? 'No Record' }}</td>
                <td>{{ $payment->payment_date ?? 'no record' }}</td>
                <td>{{ $payment->order->candidate->name ?? 'no record' }}</td>
                <td>{{ $payment->amount ?? 'no record' }}</td>
                <td>{{ $payment->status ?? 'no record' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

