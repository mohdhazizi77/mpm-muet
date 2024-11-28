<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penyata Kewangan Bulan {{ date('m' , strtotime($payments->first()->payment_date)) }} Tahun XXX</title>
</head>
<body>
    <div>
        <div style="text-align: center;padding-bottom: 10px">
            <label for="" style="font-size: 18pt;font-weight: bolder">Penyata Kewangan Bulan {{ date('m' , strtotime($payments->first()->payment_date)) }} Tahun XXX</label>
        </div>
        <table width="100%" style="border-collapse: collapse">
            <thead>
                <tr style="border: 1px solid black; padding: 5px">
                    <th style="border: 1px solid black; padding: 5px">Bil</th>
                    <th style="border: 1px solid black; padding: 5px">Transaction ID</th>
                    <th style="border: 1px solid black; padding: 5px">Transaction Date</th>
                    <th style="border: 1px solid black; padding: 5px">Receipt No.</th>
                    <th style="border: 1px solid black; padding: 5px">Amount</th>
                    <th style="border: 1px solid black; padding: 5px">Status</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if ($payments->count() > 0)
                    @foreach ($payments as $payment)
                        <tr style="border: 1px solid black; padding: 5px">
                            <td style="border: 1px solid black; padding: 5px">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $payment->order->unique_order_id }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ date('d/m/Y' , strtotime($payment->payment_date)) }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $payment->ref_no ?? 'No Record' }}</td>
                            <td style="border: 1px solid black; padding: 5px">RM {{ $payment->amount }}</td>
                            <td style="border: 1px solid black; padding: 5px">{{ $payment->status }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;padding: 10px;border: 1px solid black">No Records</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
