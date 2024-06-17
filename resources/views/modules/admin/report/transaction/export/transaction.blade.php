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
                <td>{{ date('d/m/Y' , strtotime($transaction->payment_date)) }}</td>
                <td>{{ $transaction->txn_id }}</td>
                <td>{{ $transaction->ref_no }}</td>
                <td>Amount : RM {{ $transaction->amount }}</td>
                <td>{{ $transaction->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

