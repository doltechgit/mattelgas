<x-layout>
    @role('admin|manager')
    <div class="d-flex justify-content-even flex-wrap ">
        <div class="card border-0 col-lg-6 col-md-12">
            <div class="card-body">
                @role('admin')
                <div class="card-header">
                    <h6 class="font-weight-bold">Transaction Summary</h6>
                </div>
                <div class="my-2">
                    <p>Total: </p>
                    <div class="row">
                        <div class="mx-3">
                            <small>Cash Transactions</small>
                            <h5>&#8358;{{number_format($cash)}}</h5>
                        </div>
                        <div class="mx-3">
                            <small>POS Transactions</small>
                            <h5>&#8358;{{number_format($pos)}}</h5>
                        </div>
                        <div class="mx-3">
                            <small>Transfer</small>
                            <h5>&#8358;{{number_format($transfer)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <p>Today: </p>
                    <div class="row">
                        <div class="mx-3">
                            <small>Cash Transactions</small>
                            <h5>&#8358;{{number_format($cash_today)}}</h5>
                        </div>
                        <div class="mx-3">
                            <small>POS Transactions</small>
                            <h5>&#8358;{{number_format($pos_today)}}</h5>
                        </div>
                        <div class="mx-3">
                            <small>Transfer</small>
                            <h5>&#8358;{{number_format($transfer_today)}}</h5>
                        </div>
                    </div>
                </div>
                @endrole

                <div class="card-header">
                    <h6 class="font-weight-bold">Import Transactions</h6>
                </div>
                <div class="my-2">
                    <form method="POST" action="transactions/import" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="import" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
                <div class="card-header">
                    <h6 class="font-weight-bold">Sync Tranaction</h6>
                </div>
                <div>
                    <a href="transactions/sync" class="btn btn-primary">Syn Transactions</a>
                </div>

            </div>
        </div>
        <div class="card border-0 col-lg-6 col-md-12">
            <div class="card-header">
                <h6 class="font-weight-bold">Filter Transaction Records</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="transactions/generate">
                    @csrf
                    <div class="form-group">
                        <label><small>From:</small></label>
                        <input type="date" name="from" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label><small>To:</small></label>
                        <input type="date" name="to" class="form-control" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
                    </div>
                </form>


            </div>
        </div>

    </div>
    <div class="card p-4">
        <div class="card-header">
            <h6 class="font-weight-bold">Filter by Payment Method</h6>
        </div>
        <form method="POST" action="transactions/generate_method" class="row my-4">
            @csrf
            <div class="form-group col-md-3 mx-2">
                <select class="form-control" name="method">
                    <option value="cash">Cash</option>
                    <option value="pos">POS</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div class="form-group col-md-3 mx-2">
                <!-- <label><small>From:</small></label> -->
                <input type="date" name="from" class="form-control" />
            </div>
            <div class="form-group col-md-3 mx-2">
                <!-- <label><small>To:</small></label> -->
                <input type="date" name="to" class="form-control" />
            </div>
            <div class="form-group col-md-3 mx-2">
                <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
            </div>
        </form>
    </div>
    @endrole
    <div class="card  my-3">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold ">Transactions</h6>
            <div>
                <a href="/" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm "><i class="fas fa-plus fa-sm text-white-50"></i> Add New Transaction</a>
                <div class="dropdown  d-sm-inline-block">
                    <button class=" btn btn-sm btn-success shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Records
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="export">CSV Report</a>
                        <a class="dropdown-item" href="transactions/report">For Upload</a>

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
                        $date = date('d-m-Y', $transaction->created_at->timestamp);
                        @endphp
                        <tr>
                            <td>
                                <a href="transactions/{{$transaction->id}}">
                                    <small>{{$transaction->created_at}}</small>
                                    <h6>{{$transaction->transaction_id}}</h6>
                                </a>
                            </td>

                            <td>
                                <h6>&#8358; {{number_format($transaction->price)}} | {{$transaction->quantity}} KG</h6>
                                <small>Discount: {{$transaction->discount}} %</small>
                                <small>Payment Methods:
                                    @if ($transaction->pay_method == 'Paid')
                                    @foreach ($transaction->methods as $method)
                                    {{$method->method}} - &#8358; {{$method->amount}},
                                    @endforeach
                                    @else
                                    {{$transaction->pay_method}}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <a href="clients/{{$transaction->client == null ? '' : $transaction->client->id}}">
                                    <h6>{{$transaction->client == null ? '' : $transaction->client->name}}</h6>
                                </a>
                                <small>Contact: {{$transaction->client == null ? '' : $transaction->client->phone}}</small>
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