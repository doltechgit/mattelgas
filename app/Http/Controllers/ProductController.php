<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => 'nullable',
            'quantity' => 'required | numeric',
            'price' => 'required | numeric',
            'date' => 'nullable',
        ]);

        Product::create([
            'date' => $request->date,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('message', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $categories = $product->categories;

        return view('products.show', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Get Product & Category Prices
        $product = Product::find($id);
        $enduser = $product->categories[0];
        $commercial = $product->categories[1];
        $retailer = $product->categories[2];

        // Update Product Name & Prices;
        $product->update(['name' => $request->name]);
        $enduser->update(['price'=> $request->end_user]);
        $commercial->update(['price' => $request->commercial]);
        $retailer->update(['price' => $request->retailer]);


        return back()->with('message', 'Product Updated succesfully');

        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
