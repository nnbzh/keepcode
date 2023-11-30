<?php

use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response('Ok');
});

Route::get('order/{order}/payment', [OrderController::class, 'paymentPage'])->name('orders.payment');
Route::post('order/pay', [OrderController::class, 'pay'])->name('orders.pay');
