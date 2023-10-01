<x-layout>
    <div class="row mb-4">
        <div class=" col-lg-8 col-md-12 ">
            <!-- Content Row -->
            <div class="bg-white p-3">

                <div class="w-100">
                    <div class="card-header border-0">
                        <h4>New Transaction</h4>
                    </div>
                    <div class="card-body">
                        <form class="" method="POST" action="transactions/store">
                            @csrf
                            <small id="error_ms"></small>

                            <input type="hidden" name="transaction_id" value="TXN_{{rand(0, 1000).time()}}">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" class="unit_price" name="unit_price" id="unit_price" value="0">
                            <input type="hidden" class="disc_est" name="disc_est" id="disc_est">
                            <div class="col-md-12   p-0">
                                <div class="row">
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control name" type="text" name="name" id="name" placeholder="Customer's Name" value="{{old('name')}}" />
                                            @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <input class="form-control phone" type="text" name="phone" id="phone" placeholder="Customer's Phone" value="{{old('phone')}}" />
                                            @error('phone')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                </div>



                                <div class="row">
                                    <span class="col-lg-6 col-md-12 px-2">
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
                                    </span>
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <!-- <div class="form-group">
                                            <select class="form-control method" id="method" name="method" value="{{old('method')}}" required>
                                                <option value="">--Payment Method--</option>
                                                <option value="Cash">Cash</option>
                                                <option value="POS">POS</option>
                                                <option value="Transfer">Transfer</option>
                                            </select>
                                        </div> -->
                                    </span>
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

                                <div class="">
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Amount: (Enter Amount if Customer is buying by Price)</small></label>
                                            <input class="form-control amount" type="number" step="any" name="amount" id="amount" placeholder="#000.00" value="{{old('amount')}}" />
                                            @error('amount')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Quantity</small></label>
                                            <input class="form-control buy_quantity" type="number" step="any" name="buy_quantity" id="buy_quantity" placeholder="0 kg" value="{{old('buy_quantity')}}" />
                                            @error('quantity')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Discount:</small></label>
                                            <input class="form-control discount" type="number" step="any" name="discount" id="discount" placeholder="Discount" value="0" />
                                            @error('discount')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>Paid:</small></label>
                                            <input class="form-control paid" type="number" step="any" name="paid" id="paid" placeholder="&#8358; 000.00" value="{{old('paid')}}" required />
                                            @error('paid')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                    <span class="col-lg-6 col-md-12 px-2">
                                        <div class="form-group">
                                            <label><small>To Balance:</small></label>
                                            <input class="form-control balance" type="number" step="any" name="balance" id="balance" placeholder="&#8358; 000.00" value="{{old('balance')}}" />
                                            @error('balance')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                            </div>
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
                                <button type="submit" class="btn btn-primary ">Save Transaction</button>
                                <button type="reset" class="btn btn-secondary"><i class="fa fa-redo"></i></button>
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
                @role('admin|manager')
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
                @endrole
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