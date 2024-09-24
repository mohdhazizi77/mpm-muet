<table>
    <thead>
    <tr>
        
    </tr>
    </thead>
    
</table>

<table>
    <thead>
        <tr>
            <th>Bil</th>
            <th>Date</th>
            <th>Reference ID</th>
            <th>Detail</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($orders as $order)
            @php
                $calon = $order->muet_calon_id != null ? $order->muetCalon : $order->modCalon;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y' , strtotime($order->created_at))}}</td>
                <td>{{ $order->unique_order_id }}</td>
                <td>{{ $order->type . " | Sesi " . $calon->sidang . " | Angka Giliran : " . $calon->index_number($calon) }}</td>
                <td>{{ $calon->nama }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

