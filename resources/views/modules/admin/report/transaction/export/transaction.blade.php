<table>
    <thead>
        <tr>
            <th>Bil</th>
            <th>Date</th>
            <th>Transaction ID</th>
            <th>Reference ID</th>
            <th>Detail</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y' , strtotime($transaction->created_at)) }}</td>
                <td>{{ $transaction->unique_order_id ?? 'no record' }}</td>
                <td>{{ $transaction->payment_ref_no ?? 'no record' }}</td>
                <td>Amount : RM {{ $transaction->amount ?? 'no record' }}</td>
                <td>{{ $transaction->current_status ?? 'no record' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

