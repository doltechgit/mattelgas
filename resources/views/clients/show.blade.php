<x-layout>
    <div class="m-2">
        <div class="row p-0 my-4">
            <div class="col-lg-6 col-md-12 mx-2 ">
                <div class="bg-white card border-0 p-4">
                    <div class="row">
                        <span class=" col-md-4"><small>Name: </small>
                            <h5 class="font-weight-bold">{{$client->name}}</h5>
                        </span>

                        <span class=" col-md-4"><small>Phone: </small>
                            <h5 class="font-weight-bold">{{$client->phone}}</h5>
                        </span>
                        <span class=" col-md-4"><small>Category: </small>
                            <h5 class="font-weight-bold">{{$client->category->name}}</h5>
                        </span>
                    </div>
                    <div class="my-2 row">
                        <span class=" col-md-4">
                            <small> Balance:</small>
                            <h6>&#8358; {{number_format($balance)}}</h6>
                        </span>
                        <span class=" col-md-4">
                            <small> Transaction Count:</small>
                            <h6>{{count($client->transactions)}}</h6>
                        </span>
                        @if($client->coupon)
                        <span class=" col-md-4">
                            <small> Coupon Code:</small>
                            <h6>{{$client->coupon->code}}</h6>
                        </span>
                        @endif
                    </div>

                </div>
                <div class="card my-3">
                    <div class="card-header">
                        <h5 class="font-weight-bold">Client Details</h5>
                    </div>
                    <form method="POST" action="clients/update/{{$client->id}}" class="p-2">
                        @csrf
                        <table class="table table-borderless p-0 m-0">

                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Client's Name:</label>
                                    </td>
                                    <td style="width: 75%">
                                        <input class="form-control" name="name" placeholder="Client Name" value="{{$client->name}}" />
                                    </td>
                                </tr>
                            </div>

                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Phone:</label>
                                    </td>
                                    <td class="">
                                        <input class="form-control" name="phone" placeholder="+23412345678" value="{{$client->phone}}" />
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Email Address:</label>
                                    </td>
                                    <td>
                                        <input class="form-control" name="email" placeholder="Enter Email Address..." value="{{$client->email}}" />
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Category:</label>
                                    </td>
                                    <td>
                                        <select class="form-control" id="category" name="category" value="{{$client->category}}" placeholder="Client Category">
                                            <option value="{{$client->category->id}}">{{$client->category->name}}</option>
                                            <option value="End User">End User</option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Retailer">Retailer</option>
                                        </select>
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Address:</label>
                                    </td>
                                    <td>
                                        <input class="form-control" name="address" placeholder="Nigeria" value="{{$client->address}}" />
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label for="name">Date of Birth:</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" name="dob" value="{{$client->dob}}" />
                                    </td>
                                </tr>
                            </div>

                        </table>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary form-control my-3" value="Save Client Details" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 card">
                <div class="card-header">
                    <h5 class="font-weight-bold">New Transaction</h5>
                </div>
                <div class="m-2">
                    <form method="POST" action="/transactions/store">
                        @csrf
                        <input type="hidden" name="transaction_id" value="TXN_{{rand(0, 1000).time()}}">
                        <input type="hidden" class="client_id" name="client_id" id="client_id" value="{{$client->id}}">
                        <input type="hidden" class="unit_price" name="unit_price" id="unit_price">
                        <input type="hidden" class="disc_est" name="disc_est" id="disc_est">

                        <table class="table table-borderless  p-0 m-0">
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label>Price:</label>
                                    </td>
                                    <td class="col-md-8">

                                        <input class="form-control category" id="cl_category" name="category" value="{{$client->category->price}}" disabled>
                                    </td>
                                </tr>
                            </div>

                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label class="mr-2" for="discount">Quantity: </label>
                                    </td>
                                    <td class="">


                                        <input class="form-control buy_quantity" type="number" step="any" name="buy_quantity" id="cl_quantity" placeholder="0 kg" value="{{old('buy_quantity')}}" />
                                        @error('quantity')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror

                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td>
                                        <label class="mr-2" for="amount">Amount: </label>
                                    </td>
                                    <td class="">
                                        <input class="form-control amount" type="number" step="any" name="amount" id="amount" placeholder="#000.00" value="{{old('amount')}}" />
                                        @error('amount')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror

                                    </td>
                                </tr>
                            </div>
                            <div class="form-group ">
                                <tr>
                                    <td>
                                        <label class="" for="discount">Discount: </label>
                                    </td>
                                    <td class="">

                                        <input class="form-control discount " type="number" step="any" name="discount" id="cl_discount" placeholder="Discount" value="0" />
                                        @error('discount')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group ">
                                <tr>
                                    <td>
                                        <label class="" for="paid">Paid: </label>
                                    </td>
                                    <td class="">

                                        <input class="form-control paid " type="number" step="any" name="paid" id="paid" placeholder="&#8358; 000.00" value="{{old('paid')}}" />
                                        @error('paid')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group ">
                                <tr>
                                    <td>
                                        <label class="" for="balance">To Balance: </label>
                                    </td>
                                    <td class="">

                                        <input class="form-control balance " type="number"  name="balance" id="balance" placeholder="&#8358; 000.00" value="{{old('balance')}}" />
                                        @error('balance')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </td>
                                </tr>
                            </div>
                            <div class="method_area">
                                <div class="row">
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <select class="form-control method" id="method" name="method[]" value="{{old('method')}}" required>
                                                <option value="">Payment Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="POS">POS</option>
                                                <option value="Transfer">Transfer</option>
                                            </select>
                                        </div>
                                    </span>
                                    <span class="col-lg-6 d-flex justify-content-between px-0">
                                        <span class="col-lg-10 col-md-12">
                                            <div class="form-group">

                                                <input class="form-control method_amount" type="number" step="any" name="method_amount[]" id="" placeholder="" required />
                                                @error('discount')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </span>
                                        <span class="">
                                            <span class="btn btn-primary btn-sm add_method"><i class="fa fa-plus"></i></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <tr>
                                <td class="">
                                    <div class="form-group">
                                        <input class="form-control buy_price" type="hidden" name="buy_price" id="cl_price" placeholder="Total Price" value="{{old('price')}}" />
                                        @error('buy_price')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="display_price  text-center">
                            <small>Total Price:</small>
                            <h3 class="mx-4 font-weight-bold">&#8358; <span class="price_display" id="cl_price_display">000.00</span></h3>
                        </div>
                        <div class="form-group m-3">
                            <input type="submit" class="btn btn-primary" value="Save Transaction" />
                            <button type="reset" class="btn btn-secondary"><i class="fa fa-redo"></i></button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <div class="card col-md-12 mx-2">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold ">Transactions History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table " id="homeTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Details</th>
                                <th>Payment/Balance</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$client->transactions)
                            <tr>
                                <td>No Transactions yet. You can make one <a href="/">here</a></td>
                            </tr>
                            @endif
                            @foreach ($client->transactions->keyBy('created_at') as $transaction)
                            <tr>
                                <td>
                                    <small>{{$transaction->created_at}}</small>
                                    <h6>{{$transaction->transaction_id}}</h6>
                                </td>
                                <td>
                                    <h6 class="p-0 m-0">&#8358; {{number_format($transaction->price)}}</h6>
                                    <small>Quantity: {{$transaction->quantity}} KG</small>
                                    <small>Discount: {{$transaction->discount}} %</small>
                                </td>
                                <td>
                                    <h6>&#8358; {{number_format($transaction->paid)}}</h6>
                                    To Bal: &#8358; {{number_format($transaction->balance)}}

                                </td>
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
    </div>

    <script>
        $(document).ready(function() {

        })
        $(document).ready(function() {
            let sum = 0
            $(".add_method").on('click', function() {
                console.log('here')
                $(".method_area").append(
                    `
                    <div class="row added_method">
                        <span class="col-lg-6 col-md-12 px-2">
                            <div class="form-group">
                                <select class="form-control method" id="method" name="method[]" value="{{old('method')}}">
                                    <option value="">Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="POS">POS</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>
                        </span>
                        <span class="col-lg-6 d-flex justify-content-between px-0">
                            <span class="col-lg-10 col-md-12">
                                <div class="form-group">
                                    <input class="form-control method_amount" type="number" step="any" name="method_amount[]" id="" placeholder="" required />
                                    @error('discount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </span>
                            <span class="">
                                <span class="btn  btn-sm remove_method"><i class="fa fa-times"></i></span>
                            </span>
                        </span>
                    </div>
                    `
                )
                // $('.method_amount').change(() => {

                //     console.log($('.method_amount').val())
                //     $('.method_amount').each(function() {
                //         sum += +$(this).val()
                //         $('.paid').val(sum)
                //     })

                // })
            })
            $(document).on('click', '.remove_method', function() {
                console.log('remove')
                $(this).closest('.added_method').remove()
            })
            $(document).on('click', '.apply_discount', () => {
                console.log('show')
                $('.discount_area').show()
            })

        })
    </script>
</x-layout>