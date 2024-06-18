<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Senarai Kewangan Muet</title>
</head>
<body>
    <div>
        <div style="text-align: center;padding-bottom: 10px">
            <label for="" style="font-size: 18pt;font-weight: bolder">Senarai Kewangan Muet</label>
        </div>
        <table width="100%" style="border-collapse: collapse">
            <thead>
                <tr style="border: 1px solid black; padding: 5px">
                    <th style="border: 1px solid black; padding: 5px">Bil</th>
                    <th style="border: 1px solid black; padding: 5px">TRANSACTION ID</th>
                    <th style="border: 1px solid black; padding: 5px">RECEIPT NO.</th>
                    <th style="border: 1px solid black; padding: 5px">TRANSACTION DATE</th>
                    <th style="border: 1px solid black; padding: 5px">CANDIDATE NAME</th>
                    <th style="border: 1px solid black; padding: 5px">AMOUNT</th>
                    <th style="border: 1px solid black; padding: 5px">STATUS</th>
                    <th style="border: 1px solid black; padding: 5px">RECEIPT</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if ($payments->count() > 0)
                        @foreach ($payments as $payment)
                            <tr style="border: 1px solid black; padding: 5px">
                                <td style="border: 1px solid black; padding: 5px">{{ $loop->iteration }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->txn_id  ?? 'Tiada Rekod' }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->receipt_number  ?? 'Tiada Rekod' }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ date('d/m/Y' , strtotime($payment->payment_date)) }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->order?->candidate?->name ?? 'Tiada Rekod' }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->amount  ?? 'Tiada Rekod' }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->status  ?? 'Tiada Rekod' }}</td>
                                <td style="border: 1px solid black; padding: 5px">{{ $payment->receipt  ?? 'Tiada Rekod' }}</td>
                            </tr>
                        @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align: center;border: 1px solid black; padding: 5px">Tiada Rekod</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>