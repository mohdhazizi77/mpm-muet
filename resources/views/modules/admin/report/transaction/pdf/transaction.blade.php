<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div style="text-align: center;padding-bottom: 10px">
            <label for="" style="font-size: 18pt;font-weight: bolder">Senarai Transaksi</label>
        </div>
        <table width="100%" style="border-collapse: collapse">
            <thead>
                <tr style="border: 1px solid black; padding: 5px">
                    <th style="border: 1px solid black; padding: 5px">Bil</th>
                    <th style="border: 1px solid black; padding: 5px">Date</th>
                    <th style="border: 1px solid black; padding: 5px">Transaction ID</th>
                    <th style="border: 1px solid black; padding: 5px">Reference ID</th>
                    <th style="border: 1px solid black; padding: 5px">Detail</th>
                    <th style="border: 1px solid black; padding: 5px">Status</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if ($transactions->count() > 0)
                    @foreach ($transactions as $transaction)
                        <tr style="border: 1px solid black; padding: 5px">
                            <td style="border: 1px solid black; padding: 5px">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ date('d/m/Y' , strtotime($transaction->payment_date)) }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->txn_id ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->ref_no ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">Amount : RM {{ $transaction->amount ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->status ?? 'no record' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center;border: 1px solid black; padding: 5px">No Records</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>