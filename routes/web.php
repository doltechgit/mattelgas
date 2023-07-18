<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('guest')->group(function(){
    Route::get('/login', [UserController::class, 'login'])->name('login');
   
    Route::post('/authenticate', [UserController::class, 'authenticate']);
});




Route::middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [UserController::class, 'logout']);

   

    // Notification
    Route::get('/notifications', [NotificationController::class, 'index']);
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::post('/transactions/store', [TransactionController::class, 'store']);
    Route::post('/transactions/client/{id}', [TransactionController::class, 'client_transaction']);
    Route::post('/transactions/update/{id}', [TransactionController::class, 'update']);
    Route::get('/print_pdf/{id}', [TransactionController::class, 'receipt_pdf']);
    Route::get('/download_pdf/{id}', [TransactionController::class, 'download_pdf']);
    Route::get('/export', [TransactionController::class, 'export']);

    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::post('/clients/store', [ClientController::class, 'store']);
    Route::post('/clients/update/{id}', [ClientController::class, 'update']);
    Route::get('/get_client/{id}', [ClientController::class, 'get_client']);
    Route::get('/search_client/{id}', [ClientController::class, 'search_client']);
    Route::get('/clients_export', [ClientController::class, 'export']);
    

    
});

Route::group(['middleware' => ['role:admin']], function(){
    //Registration
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);
    //Settings
    Route::get('/settings', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('/users/update/{id}', [UserController::class, 'update']);
    Route::get('/users/delete/{id}', [UserController::class, 'destroy']);

    // Store
    Route::get('/store', [StoreController::class, 'index']);
    Route::post('/store/update/{id}', [StoreController::class, 'update']);

});
Route::group(['middleware' => ['role:manager|admin']], function () {
    // Transactions
    Route::get('/transactions/delete/{id}', [TransactionController::class, 'destroy']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::post('/products/update/{id}', [ProductController::class, 'update']);

    // Stocks
    Route::get('/stocks', [StockController::class, 'index']);
    Route::get('/stocks/create', [StockController::class, 'create']);
    Route::post('/stocks/store', [StockController::class, 'store']);
    Route::get('/stocks_export', [StockController::class, 'export']);
});