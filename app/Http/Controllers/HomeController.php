<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\CurrentStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::find(1);
        $clients = Client::all();
        $current_product = Product::find(1);
        $transactions = Transaction::all();
        $latest_transaction = Transaction::latest()->first();
        $categories = Category::all();
        $prev_date = date('Y-m-d', time() - 60 * 60 * 24);
        $yest_price = Transaction::whereBetween('created_at', [$prev_date . ' 00:00:00', $prev_date . ' 23:59:59'])->sum('price');
        $yest_quantity = Transaction::whereBetween('created_at', [$prev_date . ' 00:00:00', $prev_date . ' 23:59:59'])->sum('quantity');
        
        return view('index', [
            'product' => $product,
            'current_product' => $current_product,
            'transactions' => $transactions,
            'latest_transaction' => $latest_transaction,
            'yest_price' => $yest_price,
            'yest_quantity' => $yest_quantity,
            'categories' => $categories,
            'clients' => $clients
        ]);
    }
}
