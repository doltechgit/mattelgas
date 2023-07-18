<x-layout>
    <div class="bg-white border col-md-7 d-flex p-3 mx-auto ">

        <div class="w-100">
            <div class="card-header border-0">
                <h4>New Product</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/products/store" class="user">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                        <div class="form-group">
                            <input class="form-control " type="text" name="name" id="name" placeholder="Product Name" value="{{old('name')}}" />
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control " type="number" name="quantity" id="quantity" placeholder="Quantity" value="{{old('quantity')}}" />
                            @error('quantity')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control " type="number" name="price" id="price" placeholder="Price per Unit" value="{{old('price')}}" />
                            @error('price')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Add Product" />
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>