<x-layout>
    @role('manager|admin')
    <div class="card col-md-6 my-4">
        <div class="card-header">
            <h6 class="font-weight-bold">Import Clients</h6>
        </div>
        <div class="my-2">
            <form method="POST" action="clients/import" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="import" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
    @endrole
    <div class="card  mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold ">Clients</h6> {{count($clients)}}
            <div>
                <a href="/" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm "><i class="fas fa-plus fa-sm text-white-50"></i> Add New Client</a>
                <div class="dropdown d-none d-sm-inline-block">
                    <button class=" btn btn-sm btn-success shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Clients Record
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="clients_export">CSV Report</a>
                        <a class="dropdown-item" href="clients_upload">For Upload</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table " id="clientTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>Client</th>
                            <th>Phone</th>
                            <th>Transactions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$clients)
                        <tr>
                            <td>No Transactions yet. You can make one <a href="/">here</a></td>
                        </tr>
                        @endif
                        @foreach ($clients->keyBy('created_at') as $client)


                        <tr>

                            <td>
                                <a href="/clients/{{$client->id}}">
                                    <h6>{{$client->name}}</h6>
                                    <small>{{$client->category->name}}</small>
                                </a>
                            </td>
                            <td>{{$client->phone}}</td>
                            <td>{{count($client->transactions)}}</td>
                            <td>
                                <x-table-list-menu show="clients" delete="clients/delete" :id='$client->id' />
                            </td>


                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>