<x-layout>
    <div class="container-fluid bg-white col-md-12 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Settings</h3>
            <div>
                <!-- <a href="trash_records"><i class="fa fa-trash"></i> Transaction Trash</a> -->
            </div>

        </div>
        <div class="card-body">
            <div class="users-section my-4">
                <div class="d-flex justify-content-between align-items-center my-2">
                    <h6>Users Settings</h6>
                    <div>
                        <a href="/register" class="btn btn-primary btn-sm">Register New User</a>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user )
                        <tr>
                            <td><a href="users/{{$user->id}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->roles->pluck('name')[0]}}</td>
                        </tr>
                        @endforeach
                        <tr>

                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="transaction-section my-5">
                <h6>Store Settings</h6>
                <hr>

                <form method="POST" action="store/update/{{$store->id}}">
                    @csrf
                    <table class="table table-borderless p-0 m-0">

                        <div class="form-group">
                            <tr>
                                <td>
                                    <label for="name">Store Name:</label>
                                </td>
                                <td style="width: 75%">
                                    <input class="form-control" name="name" placeholder="Enter Store Name..." value="{{$store->name}}" />
                                </td>
                            </tr>
                        </div>

                        <div class="form-group">
                            <tr>
                                <td>
                                    <label for="name">Contact:</label>
                                </td>
                                <td class="">
                                    <input class="form-control" name="contact" placeholder="+23412345678" value="{{$store->contact}}" />
                                </td>
                            </tr>
                        </div>
                        <div class="form-group">
                            <tr>
                                <td>
                                    <label for="name">Email Address:</label>
                                </td>
                                <td>
                                    <input class="form-control" name="email" placeholder="Enter Email Address..." value="{{$store->email}}" />
                                </td>
                            </tr>
                        </div>
                        <div class="form-group">
                            <tr>
                                <td>
                                    <label for="name">Store Address:</label>
                                </td>
                                <td>
                                    <input class="form-control" name="address" placeholder="Nigeria" value="{{$store->address}}" />
                                </td>
                            </tr>
                        </div>
                    </table>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Save Store Details" />
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-layout>