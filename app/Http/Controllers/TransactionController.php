<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\CurrentStock;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionExport;
use App\Exports\TransactionUpdateExport;
use App\Exports\TransactionSortReport;
use App\Exports\MethodReport;
use App\Imports\TransactionImport;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Method;
use App\Models\Stock;
use App\Notifications\TransactionNotification;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = date('Y-m-d', time());
        $cash = Transaction::where('pay_method', 'cash')->sum('paid');
        $cash_method = Method::where('method', 'cash')->sum('amount');
        $cash_total = $cash_method + $cash;
        $pos = Transaction::where('pay_method', 'pos')->sum('paid');
        $pos_method = Method::where('method', 'pos')->sum('amount');
        $pos_total = $pos_method + $pos;
        $transfer = Transaction::where('pay_method', 'transfer')->sum('paid');
        $transfer_method = Method::where('method', 'transfer')->sum('amount');
        $transfer_total = $transfer_method + $transfer;
        $discount = Transaction::all()->sum('discount');
        $discount_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])->sum('discount');
        $balance =  Transaction::all()->sum('balance');
        $balance_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])->sum('balance');
        $paid = Transaction::all()->sum('paid');
        $paid_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])->sum('paid');
        $total = Transaction::all()->sum('price');
        $pos_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'pos')->sum('paid');
        $pos_method_today = Method::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('method', 'pos')->sum('amount');
        $pos_total_today = $pos_today + $pos_method_today;
        $cash_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'cash')->sum('paid');
        $cash_method_today = Method::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('method', 'cash')->sum('amount');
        $cash_total_today = $cash_today + $cash_method_today;
        $transfer_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'transfer')->sum('paid');
        $transfer_method_today = Method::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('method', 'transfer')->sum('amount');
        $transfer_total_today = $transfer_today + $transfer_method_today;
        $transactions = Transaction::all();
        return view('transactions.index', [
            'transactions' => $transactions,
            'cash' => $cash_total,
            'pos' => $pos_total,
            'discount' => $discount,
            'discount_today' => $discount_today,
            'paid' => $paid,
            'paid_today' => $paid_today,
            'balance' => $balance,
            'balance_today' => $balance_today,
            'total' => $total,
            'transfer' => $transfer_total,
            'cash_today' => $cash_total_today,
            'pos_today' => $pos_total_today,
            'transfer_today' => $transfer_total_today
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function import(Request $request)
    {
        // dd($request->import);
        Excel::import(new TransactionImport, $request->import);
        return back()->with('message', 'Import Successful');
    }

    public function sync()
    {
        // dd($request->import);
        $product = Product::find(1);
        $transction_sum = Transaction::all()->sum('quantity');
        $stock = Stock::pluck('new_quantity')->first();
        $added = Stock::pluck('add_quantity')->skip(1)->sum();



        $current = $stock - $transction_sum;
        $product->quantity = $current + $added;
        $product->save();

        return back()->with('message', 'Stocks Updated');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $method_amount = $request->input('method_amount', []);
        $product = Product::find('1');
        $users = User::all();
        $category = Category::where('price', $request->category)->first();
        $name = $request->name;
        $phone = $request->phone;

        if ($product->quantity == 0) {
            return back()->with('message', 'Restock, Product Quantity is low');
        }
        if ($name == '') {
            $name = 'User_' . rand(0, 1000) . time();
        }
        if ($phone == '') {
            $phone = rand(0, 1000) . time();
        }
        if ($request->exists('client_id') === false) {
            $client = Client::firstOrCreate([
                'name' => $name,
                'phone' => $phone,
                'email' => $request->email,
                'address' => $request->address,
                'dob' => $request->dob,
                'category_id' => $category->id
            ]);
            $client->save();
            $client_id = $client->id;

            $transaction = Transaction::create([
                'transaction_id' => $request->transaction_id,
                'product_id' => $request->product_id,
                'user_id' => auth()->user()->id,
                'client_id' => $client_id,
                'quantity' => $request->buy_quantity,
                'price' => $request->buy_price,
                'pay_method' => 'Paid',
                'discount' => $request->discount,
                'paid' => $request->paid,
                'balance' => $request->balance

            ]);

            foreach ($request->input('method', []) as $index => $method) {

                Method::create([
                    'transaction_id' => $transaction->id,
                    'method' => $method,
                    'amount' => $method_amount[$index]
                ]);
            }
        } else if ($request->exists('client_id') === true) {
            $client = Client::find($request->client_id);

            $transaction = Transaction::create([
                'transaction_id' => $request->transaction_id,
                'product_id' => $request->product_id,
                'user_id' => auth()->user()->id,
                'client_id' => $client->id,
                'quantity' => $request->buy_quantity,
                'price' => $request->buy_price,
                'pay_method' => 'Paid',
                'discount' => $request->discount,
                'paid' => $request->paid,
                'balance' => $request->balance

            ]);

            foreach ($request->input('method', []) as $index => $method) {

                Method::create([
                    'transaction_id' => $transaction->id,
                    'method' => $method,
                    'amount' => $method_amount[$index]
                ]);
            }
        }

        $updated_quantity = $product->quantity - $transaction->quantity;
        $product->quantity = $updated_quantity;
        $product->save();
        Notification::send($users, new TransactionNotification($transaction->transaction_id));
        return redirect('transactions/' . $transaction->id)->with('message', 'Transaction Successful!');
        // return response()->json([
        //     'status' => 200,
        //     'redirect' => 'transactions/'.$transaction->id,
        // ]);
    }

    public function client_transaction(Request $request, $id)
    {
        // dd($request->paid);
        $method_amount = $request->input('method_amount', []);
        $product = Product::find(1);
        $users = User::all();
        $client = Client::find($id);


        if ($product->quantity == 0) {
            return back()->with('message', 'Restock, Product Quantity is low');
        }



        $transaction = Transaction::create([
            'transaction_id' => $request->transaction_id,
            'product_id' => $product->id,
            'user_id' => auth()->user()->id,
            'client_id' => $client->id,
            'quantity' => $request->buy_quantity,
            'price' => $request->buy_price,
            'pay_method' => $request->method,
            'discount' => $request->discount,
            'paid' => $request->paid,
            'balance' => 0
        ]);
        $transaction->save();
        foreach ($request->input('method', []) as $index => $method) {

            Method::create([
                'transaction_id' => $transaction->id,
                'method' => $method,
                'amount' => $method_amount[$index]
            ]);
        }

        $updated_quantity = $product->quantity - $transaction->quantity;
        $product->quantity = $updated_quantity;
        $product->save();

        // Generate Coupon
        if (count($client->transactions) == 4 && $client->category->slug == 'end_user') {
            $code = uniqid('mtg_');
            $coupon = Coupon::create([
                'client_id' => $client->id,
                'code' => $code,
            ]);
            $coupon->save();
        }

        // Send Notification of Transaction
        Notification::send($users, new TransactionNotification($transaction->transaction_id));

        // Redirect
        return redirect('transactions/' . $transaction->id)->with('message', 'Transaction Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        return view('transactions.show', [
            'transaction' => $transaction
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
        // dd($request->input());
        $method_amount = $request->input('method_amount', []);
        $transaction = Transaction::find($id);

        $transaction->paid = $transaction->paid + $request->paid;
        $transaction->balance = $transaction->balance - $request->paid;
        $transaction->save();
        foreach ($request->input('method', []) as $index => $method) {
            
            Method::create([
                'transaction_id' => $transaction->id,
                'method' => $method,
                'amount' => $method_amount[$index]
            ]);
        }

        return back()->with('message', 'Transaction updated!');
    }

    public function receipt_pdf($id)
    {

        $transaction = Transaction::find($id);
        $pdf = Pdf::loadView('transactions.receipt', [
            'transaction' => $transaction
        ])->setPaper('mattel', 'portrait');
        return $pdf->stream('mattel_gas_' . $transaction->transaction_id . '.pdf');
    }
    public function download_pdf($id)
    {

        $transaction = Transaction::find($id);
        $pdf = Pdf::loadView('transactions.receipt', [
            'transaction' => $transaction
        ])->setPaper('mattel', 'portrait');
        return $pdf->download('mattel_gas_' . $transaction->transaction_id . '.pdf');
    }

    public function export()
    {
        return Excel::download(new TransactionExport, 'transactions.csv');
    }

    public function report()
    {
        return Excel::download(new TransactionUpdateExport, 'trans_update.csv');
    }

    public function generate(Request $request)
    {

        return (new TransactionSortReport($request->from, $request->to))->download('mt-report.csv');
        // dd($transaction);
    }

    public function generate_method(Request $request)
    {

        $methods = Method::whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59'])->where('method', $request->method)->get();
        return (new MethodReport($methods))->download('mtg-' . $request->method . '.csv');
        // dd($transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $product = Product::find(1);

        $renew_quantity = $product->quantity + $transaction->quantity;
        $product->quantity = $renew_quantity;
        $product->save();

        $transaction->delete();

        return back()->with('message', 'Transaction deleted');
    }
}
