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
use App\Exports\TransactionSortReport;
use App\Exports\MethodReport;
use App\Models\Category;
use App\Models\Coupon;
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
        $cash = Transaction::where('pay_method', 'cash')->sum('price');
        $pos = Transaction::where('pay_method', 'pos')->sum('price');
        $transfer = Transaction::where('pay_method', 'transfer')->sum('price');
        $today = date('Y-m-d', time());
        $pos_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'pos')->sum('price');
        $cash_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'cash')->sum('price');
        $transfer_today = Transaction::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
        ->where('pay_method', 'transfer')->sum('price');
        $transactions = Transaction::all();
        return view('transactions.index', [
            'transactions' => $transactions,
            'cash' => $cash,
            'pos' => $pos,
            'transfer' => $transfer,
            'cash_today' => $cash_today,
            'pos_today' => $pos_today,
            'transfer_today' => $transfer_today
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $product = Product::find('1');
        $users = User::all();
        $category = Category::where('price', $request->category)->first();
        

        if($product->quantity == 0){
            return back()->with('message', 'Restock, Product Quantity is low');
        }
        $client = Client::firstOrCreate([
            'name' => $request->name,
            'phone' => $request->phone,
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
            'pay_method' => $request->method,
            'discount' => $request->discount,
            'paid' => $request->paid,
            'balance' => $request->balance

        ]);

        $updated_quantity = $product->quantity - $transaction->quantity;
        $product->quantity = $updated_quantity;
        $product->save();
        Notification::send($users, new TransactionNotification($transaction->transaction_id));
        // return redirect('transactions/'.$transaction->id)->with('message', 'Transaction Successful!');
        return response()->json([
            'status' => 200,
            'redirect' => 'transactions/'.$transaction->id,
        ]);
    }

    public function client_transaction(Request $request, $id)
    {
        // dd($request->input());
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
            'balance' => $request->balance
        ]);

        $updated_quantity = $product->quantity - $transaction->quantity;
        $product->quantity = $updated_quantity;
        $product->save();

        // Generate Coupon
        if (count($client->transactions) == 4 && $client->category->slug == 'end_user'){
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
        $transaction = Transaction::find($id);

        $transaction->paid = $transaction->paid + $request->paid;
        $transaction->balance = $transaction->balance - $request->paid;
        $transaction->save();

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
        ]);
        return $pdf->download('mattel_gas_' . $transaction->transaction_id . '.pdf');
    }

    public function export()
    {
        return Excel::download(new TransactionExport, 'transactions.csv');
    }

    public function generate(Request $request)
    {
    
        return (new TransactionSortReport($request->from, $request->to))->download('mt-report.csv');
        // dd($transaction);
    }

    public function generate_method(Request $request)
    {

        return (new MethodReport($request->from, $request->to, $request->method))->download('mt-'. $request->method.'.csv');
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
