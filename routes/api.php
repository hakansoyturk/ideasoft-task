<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getCustomers', [CustomerController::class, 'index']);

    Route::get('/getProducts', [ProductController::class, 'index']);
 
    Route::get('/getOrders', [OrderController::class, 'index']);
    Route::post('/createOrder', [OrderController::class, 'store']);
    Route::delete('/deleteOrder/{orderId}', [OrderController::class, 'destroy']);

    Route::get('/getDiscount/{orderId}', [DiscountController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


