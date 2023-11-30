<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CartItemController;
use App\Http\Controllers\API\FreePaymentWebhookController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderStatusController;
use App\Http\Controllers\API\OrderWebhookController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductStatusController;
use App\Http\Controllers\API\RentalTypeController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('orders', [UserController::class, 'orders']);
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart/clear', [CartController::class, 'clear']);
        Route::resource('cart.items', CartItemController::class)
            ->only(['store', 'destroy'])
            ->shallow();
    });

    Route::resource('orders', OrderController::class)->only(['index', 'store']);
    Route::post('orders/prolongation', [OrderController::class, 'prolongation']);
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/statuses', ProductStatusController::class);
Route::post('orders/free/webhook', FreePaymentWebhookController::class)->name('api.orders.free.webhook');
Route::get('orders/statuses', OrderStatusController::class);
Route::get('rental/types', RentalTypeController::class);
