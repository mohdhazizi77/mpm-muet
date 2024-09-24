<table>
    <thead>
        <tr>
            <th>#</th>
            <th>DATE CREATED</th>
            <th>DATE COMPLETED</th>
            <th>TRANSACTION ID</th>
            <th>REFERENCE ID</th>
            <th>AMOUNT</th>
            <th>EXAM TYPE</th>
            <th>TRANSACTION TYPE</th>
            <th>CANDIDATE NAME</th>
            <th>CANDIDATE NRIC</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y' , strtotime($transaction->created_at)) }}</td>
                <td>{{ !empty($transaction->completed_at) ? date('d/m/Y' , strtotime($transaction->completed_at)) : date('d/m/Y' , strtotime($transaction->updated_at)) }}</td>
                <td>{{ $transaction->unique_order_id ?? 'no record' }}</td>
                <td>{{ $transaction->payment_ref_no ?? 'no record' }}</td>
                <td>RM {{ $transaction->payment->amount ?? 'no record' }}</td>
                <td>{{ $transaction->type ?? 'no record' }}</td>
                <td>{{ $transaction->payment_for ?? 'no record' }}</td>
                <td>{{ $transaction->candidate->name ?? 'no record' }}</td>
                <td>{{ $transaction->candidate->identity_card_number ?? 'no record' }}</td>
                <td>{{ $transaction->current_status ?? 'no record' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

