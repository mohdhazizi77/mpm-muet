<table>
    <thead>
        <tr>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Bil</th>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Sender Name</th>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Sender Email</th>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Sender Contact No</th>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Sender Address</th>
            <th style="mso-number-format: '\@'; background-color: #F7FFBA; color: black;">Sender Postcode</th>
            <th style="mso-number-format: '\@'; background-color: #D4FFCC; color: black;">Receiver Name</th>
            <th style="mso-number-format: '\@'; background-color: #D4FFCC; color: black;">Receiver Email</th>
            <th style="mso-number-format: '\@'; background-color: #D4FFCC; color: black;">Receiver Contact No</th>
            <th style="mso-number-format: '\@'; background-color: #D4FFCC; color: black;">Receiver Address</th>
            <th style="mso-number-format: '\@'; background-color: #D4FFCC; color: black;">Receiver Postcode</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Item Weight (kg)</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Item Width (cm)</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Item Length (cm)</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Item Height (cm)</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Category</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Item Description</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Parcel Notes</th>
            <th style="mso-number-format: '\@'; background-color: #CCCEFF; color: black;">Sender Ref No</th>
            <th style="mso-number-format: '\@'; background-color: #FFCCCC; color: black;">Insurance (MYR)</th>
        </tr>
        
    </thead>
    <tbody>
        @foreach ($orders as $order)
        @php
            $address = ($order->address1 || $order->address2) ? $order->address1 . ', ' . $order->address2 : 'Tiada Rekod';
        @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>SUB(PSM)</td>
                <td>muet@mpm.edu.my</td>
                <td>0361261600</td>
                <td>Majlis Peperiksaan Malaysia, Persiaran 1, Bandar Baru Selayang, Batu Caves, Selangor</td>
                <td>68100</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone_num }}</td>
                <td>{{ $address  }}</td>
                <td>{{ $order->postcode ?? 'Tiada Rekod' }}</td>
                <td>0.50</td>
                <td>0.10</td>
                <td>0.10</td>
                <td>0.10</td>
                <td>Document</td>
                <td>MUET Certificate</td>
                <td>
                    {{ $order->unique_order_id }} <span>(Do Not Fold)</span>
                </td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
