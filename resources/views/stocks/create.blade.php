<x-layout>
    <div class="bg-white border col-md-7 d-flex p-3 mx-auto ">

        <div class="w-100">
            <div class="card-header border-0">
                <h4>Restock</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/stocks/store" class="user">
                    @csrf

                    <input type="hidden" name="transaction_id" value="STK_{{rand(0, 1000).time()}}">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <select class="form-control" id="stk_product" name="product" value="{{old('product')}}" placeholder="Quantity">
                            <option value="Select KG">--Select Product--</option>
                            @foreach ($products as $product )
                            <option value="{{$product->quantity}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group">
                                <select class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}" placeholder="Quantity">
                                    <option value="Select KG">--Select Quantity--</option>
                                    @foreach ($products as $product )
                                    <option value="{{$product->quantity}}">{{$product->name}}--{{$product->quantity}}</option>
                                    @endforeach
                                </select>
                            </div> -->
                    <div class="form-group">
                        <input class="form-control " type="number" name="quantity" id="stk_quantity" placeholder="Current Quantity" value="{{old('quantity')}}" />
                        @error('quantity')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control " type="number" name="add_quantity" id="add_quantity" placeholder="Quantity to add" value="{{old('add_quantity')}}" />
                        @error('quantity')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control " type="number" name="new_quantity" id="new_quantity" placeholder="Total Quantity" value="{{old('new_quantity')}}" />
                        @error('quantity')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update Stock" />
                    </div>
                </form>
            </div>
        </div>
    </div>

   

</x-layout>