<table>
    <thead>
        <tr>
            <th>Bil</th>
            <th>Transaction ID</th>
            <th>Transaction Date</th>
            <th>Receipt No.</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->txn_id }}</td>
                <td>{{ date('d/m/Y' , strtotime($payment->payment_date)) }}</td>
                <td>{{ $payment->receipt_number ?? 'Tiada Rekod' }}</td>
                <td>RM {{ $payment->amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
