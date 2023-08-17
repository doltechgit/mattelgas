<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Stock ID</th>
            <th>Product</th>
            <th>Previous Qty.</th>
            <th>Added Qty.</th>
            <th>New Qty./th>
            <th>Restocked by</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        @php
        $date = explode(' ', $stock->created_at);
        $created_at = $date[0];
        @endphp

        <tr>
            <td>{{ $created_at }}</td>
            <td>{{ $stock->stock_stamp }}</td>
            <td>{{ $stock->product->name }}</td>
            <td>{{ $stock->prev_quantity }}</td>
            <td>{{ $stock->add_quantity }}</td>
            <td>{{ $stock->new_quantity }}</td>
            <td>{{ $stock->user->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>