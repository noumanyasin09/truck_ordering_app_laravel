<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OrdersController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});

Route::prefix( 'orders')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [OrdersController::class,'createOrder']);
    Route::get('/', [ordersController::class, 'getOrders']);
    Route::post('/updatestatus', [ordersController::class, 'updateOrderStatus']);
});

