<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Date of Birth</th>
            <th>Category</th>
            <th>No. of Transactions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        @php
        $date = explode(' ', $client->created_at);
        $created_at = $date[0];
        @endphp

        <tr>
            <td>{{ $created_at }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->dob }}</td>
            <td>{{ $client->category->name }}</td>
            <td>{{ $client->trans_no }}</td>
        </tr>
        @endforeach
    </tbody>
</table>