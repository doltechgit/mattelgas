<x-layout>
    <div class="row my-4">
        <div class="col-lg-8 col-md-12">
            <!-- Content Row -->
            <div class="bg-white border col-md-12 p-3 mx-auto ">

                <div class="w-100">
                    <div class="card-header border-0">
                        <h4>New Transaction</h4>
                    </div>
                    <div class="card-body">
                        <form class="transaction_form">
                            @csrf
                            <small id="error_ms"></small>

                            <input type="hidden" name="transaction_id" value="TXN_{{rand(0, 1000).time()}}">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" class="unit_price" name="unit_price" id="unit_price" value="0">
                            <input type="hidden" class="disc_est" name="disc_est" id="disc_est">
                            <table class="col-md-12   p-0">
                                <tr>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control name" type="text" name="name" id="name" placeholder="Customer's Name" value="{{old('name')}}" required />
                                            @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control phone" type="text" name="phone" id="phone" placeholder="Customer's Phone" value="{{old('phone')}}" required />
                                            @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control email" type="email" name="email" id="email" placeholder="Customer's Email" value="{{old('email')}}" />
                                            @error('email')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control address" type="text" name="address" id="address" placeholder="Customer's Address" value="{{old('address')}}" />
                                            @error('address')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <select class="form-control category" id="category" name="category" value="{{old('method')}}" required>
                                                <option value="Select KG">--Customer Category--</option>
                                                @forelse ($categories as $category )
                                                <option value="{{$category->price}}">{{$category->name}} - # {{$category->price}}</option>
                                                @empty
                                                <option value="No Category">No Category</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </td>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <select class="form-control method" id="method" name="method" value="{{old('method')}}" required>
                                                <option value="Select KG">--Payment Method--</option>
                                                <option value="Cash">Cash</option>
                                                <option value="POS">POS</option>
                                                <option value="Transfer">Transfer</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <small>Note</small>
                                        <p>Enter Amount if Customer is buying by Price</p>
                                    </td>

                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Amount:</small></label>
                                            <input class="form-control amount" type="number" name="amount" id="amount" placeholder="#000.00" value="{{old('amount')}}" />
                                            @error('amount')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Quantity</small></label>
                                            <input class="form-control buy_quantity" type="number" name="buy_quantity" id="buy_quantity" placeholder="0 kg" value="{{old('buy_quantity')}}"  />
                                            @error('quantity')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Discount:</small></label>
                                            <input class="form-control discount" type="number" name="discount" id="discount" placeholder="Discount" value="0" />
                                            @error('discount')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Paid:</small></label>
                                            <input class="form-control paid" type="number" name="paid" id="paid" placeholder="&#8358; 000.00" value="{{old('paid')}}" required />
                                            @error('paid')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>To Balance:</small></label>
                                            <input class="form-control balance" type="number" name="balance" id="balance" placeholder="&#8358; 000.00" value="{{old('balance')}}" />
                                            @error('balance')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <input class="form-control buy_price" type="hidden" name="buy_price" id="buy_price" placeholder="Total Price" value="{{old('price')}}" />
                                @error('price')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="display_price text-center ">
                                <small class="">Total Price:</small>
                                <h3 class="mx-4 font-weight-bold ">&#8358; <span class="price_display" id="price_display">000.00</span></h3>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit_transaction">Save Transaction</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white col-lg-4 col-md-12  p-4">
            <div class=" row ">
                <div class="col-md-5">
                    <small>Current Stock</small>
                    @if (!$current_product)
                    <h3 class="h3">0 KG</h3>
                    @else
                    <h3 class="h3 font-weight-bold text-success m-0">{{$current_product->quantity}} KG</h3>
                    @endif
                    <a href="stocks/create" class="btn btn-link">Restock</a>
                </div>
                <div class="col-md-7">
                    <small>Latest Transaction</small>
                    @if(!$latest_transaction)
                    <h3 class="font-weight-bold m-0">&#8358; 000.00</h3>
                    <small>TXN_000000000</small> |
                    <small>0 KG</small>
                    @else
                    <h3 class="font-weight-bold m-0">&#8358; {{number_format($latest_transaction->price)}}</h3>
                    <small>{{$latest_transaction->transaction_id}}</small> |
                    <small>{{$latest_transaction->quantity}} KG</small>
                    @endif
                </div>

            </div>
            <div class="  my-4">
                <small>Prices per KG</small>
                <hr>
                <div class="row">

                    @forelse ($product->categories as $category )
                    <div class="col-md-4">
                        <small>{{$category->name}}</small>
                        <h3 class="font-weight-bold">&#8358; {{$category->price}}</h3>
                    </div>
                    @empty
                    <h3>No prices set yet</h3>
                    @endforelse

                </div>
            </div>
            <div class="col-md-12  my-4">
                <small>Yesterday's Total</small>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3  font-weight-bold">&#8358;
                            @if(!$yest_price)
                            00.00
                            @else
                            {{number_format($yest_price)}}
                            @endif
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h3  font-weight-bold">
                            @if(!$yest_quantity)
                            00.00
                            @else
                            {{number_format($yest_quantity)}}
                            @endif
                            KG
                        </h3>
                    </div>
                </div>
            </div>





        </div>
    </div>
    <div class="card  mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold ">Clients</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table " id="homeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Client Category</th>
                            <th>Transaction Count</th>
                            <th>Coupon</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$clients)
                        <tr>
                            <td>No Client yet..</td>
                        </tr>
                        @endif
                        @foreach ($clients->keyBy('created_at') as $client)


                        <tr>
                            <td>{{$client->name}}</td>
                            <td>{{$client->phone}}</td>
                            <td>{{$client->category->name}}</td>
                            <td>{{count($client->transactions)}}</td>
                            <td>Nil</td>
                            <!-- <td>
                                <x-table-list-menu show="transactions" delete="transactions/delete" :id='$client->id' />
                            </td> -->
                            <td>
                                <a href="/clients/{{$client->id}}">
                                    <button type="button" class="btn btn-light">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Client Transaction Modal-->
    @include('partials._client-transaction')
    @include('partials._confirm-transaction')

</x-layout>