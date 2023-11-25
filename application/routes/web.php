<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    $products = \App\Models\Product::all();
    return view('welcome', ['products' => $products]);
});
Route::get('/settings', [AdminController::class, 'index']);
Route::post('/settings', [AdminController::class, 'updateSettings']);

Route::get('/tokens/create', [AdminController::class, 'createToken']);
Route::post('/tokens', [AdminController::class, 'storeToken']);
Route::patch('/tokens/{token}', [AdminController::class, 'updateToken']);
Route::get('/tokens/{token}/edit', [AdminController::class, 'editToken']);
Route::get('/tokens/{token}/delete', [AdminController::class, 'deleteToken']);

Route::get('/products/create', [AdminController::class, 'createProduct']);
Route::post('/products', [AdminController::class, 'storeProduct']);
Route::patch('/products/{product}', [AdminController::class, 'updateProduct']);
Route::get('/products/{product}/edit', [AdminController::class, 'editProduct']);
Route::get('/products/{product}/delete', [
    AdminController::class,
    'deleteProduct',
]);

Route::get('/products/{product}/add-to-cart', [
    TransactionController::class,
    'addToCart',
]);
Route::get('/cart', [TransactionController::class, 'cart']);
Route::get('/cart/remove', [TransactionController::class, 'removeFromCart']);
Route::get('/checkout', [TransactionController::class, 'checkout']);
Route::get('/pay', [TransactionController::class, 'pay']);
Route::get('/pay/{uniqueCode}', [TransactionController::class, 'returnview']);
Route::get('/success', [TransactionController::class, 'success']);
Route::get('/check-transaction', [
    TransactionController::class,
    'checkTransaction',
]);
Route::get('/transactions', [TransactionController::class, 'index']);
