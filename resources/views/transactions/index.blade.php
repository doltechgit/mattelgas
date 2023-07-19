<x-layout>
    <div class="card  mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold ">Transactions</h6>
            <div>
                <a href="/" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm "><i class="fas fa-plus fa-sm text-white-50"></i> Add New Transaction</a>
                <div class="dropdown  d-sm-inline-block">
                    <button class=" btn btn-sm btn-success shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Records
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="export">CSV</a>
                        <a class="dropdown-item" href="#">PDF</a>

                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="transTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Details</th>
                            <th>Client</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$transactions)
                        <tr>
                            <td>No Transactions yet. You can make one <a href="/">here</a></td>
                        </tr>
                        @endif
                        @foreach ($transactions->keyBy('created_at') as $transaction)

                        @php
                        $date = date('D d-M-Y', $transaction->created_at->timestamp);
                        @endphp
                        <tr>
                            <td>
                                <a href="transactions/{{$transaction->id}}">
                                    <h6>{{$transaction->transaction_id}}</h6>
                                    <small>{{$date}}</small>
                                </a>
                            </td>

                            <td>
                                <h6># {{number_format($transaction->price)}}</h6>
                                <small>Quantity: {{$transaction->quantity}} KG</small>
                                <small>Discount: {{$transaction->discount}} %</small>

                            </td>
                            <td>
                                <a href="clients/{{$transaction->client->id}}">
                                    <h6>{{$transaction->client->name}}</h6>
                                </a>
                                <small>Contact: {{$transaction->client->phone}}</small>
                            <td>
                                <x-table-list-menu show="transactions" delete="transactions/delete" :id='$transaction->id' />
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-layout>