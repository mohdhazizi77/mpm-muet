<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body, table {
            font-size: 11pt;
        }
    </style>
</head>
<body>
    <div>
        <div style="text-align: center;padding-bottom: 10px">
            <label for="" style="font-size: 15pt;font-weight: bolder">Transaction List</label>
        </div>
        <table width="100%" style="border-collapse: collapse">
            <thead>
                <tr style="border: 1px solid black; padding: 5px">
                    <th style="border: 1px solid black; padding: 5px">#</th>
                    <th style="border: 1px solid black; padding: 5px">DATE CREATED</th>
                    <th style="border: 1px solid black; padding: 5px">DATE COMPLETED</th>
                    <th style="border: 1px solid black; padding: 5px">TRANSACTION ID</th>
                    <th style="border: 1px solid black; padding: 5px">REFERENCE ID</th>
                    <th style="border: 1px solid black; padding: 5px">AMOUNT</th>
                    <th style="border: 1px solid black; padding: 5px">EXAM TYPE</th>
                    <th style="border: 1px solid black; padding: 5px">TRANSACTION TYPE</th>
                    <th style="border: 1px solid black; padding: 5px">CANDIDATE NAME</th>
                    <th style="border: 1px solid black; padding: 5px">CANDIDATE NRIC</th>
                    <th style="border: 1px solid black; padding: 5px">STATUS</th>

                </tr>
            </thead>
            <tbody style="text-align: center">
                @if ($transactions->count() > 0)
                    @foreach ($transactions as $transaction)
                        <tr style="border: 1px solid black; padding: 5px">
                            <td style="border: 1px solid black; padding: 5px">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ date('d/m/Y' , strtotime($transaction->created_at)) }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ !empty($transaction->completed_at) ? date('d/m/Y' , strtotime($transaction->completed_at)) : date('d/m/Y' , strtotime($transaction->updated_at)) }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->unique_order_id ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->payment_ref_no ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">RM {{ $transaction->payment->amount ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->type ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->payment_for ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->candidate->name ?? 'no record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->candidate->identity_card_number }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $transaction->current_status ?? 'no record' }}</td>
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
