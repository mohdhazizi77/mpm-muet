<table>
    <thead>
        <tr>
            <th>Bil</th>
            <th>Transaction ID</th>
            <th>Receipt No</th>
            <th>Transaction Date</th>
            <th>Candidate Name</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y' , strtotime($payment->created_at)) }}</td>
                <td>{{ $payment->order->unique_order_id ?? 'no record' }}</td>
                <td>{{ $payment->payment_date ?? 'no record' }}</td>
                <td>{{ $payment->order->candidate->name ?? 'no record' }}</td>
                <td>Amount : RM {{ $payment->amount ?? 'no record' }}</td>
                <td>{{ $payment->status ?? 'no record' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

