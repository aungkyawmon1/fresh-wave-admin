<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [MobileController::class, 'login']);
    Route::post('/register', [MobileController::class, 'register']);
    Route::post('/logout', [MobileController::class, 'logout']);
    Route::post('/refresh', [MobileController::class, 'refresh']);
    Route::get('/aps', [MobileController::class, 'aps']);
    Route::get('/user-profile', [MobileController::class, 'userProfile']);   
    
    Route::post('/orders', [MobileController::class, 'orderList']);
    Route::post('/change-status', [MobileController::class, 'changeOrderStatus']);

    Route::get('/posts', [MobileController::class, 'getPosts']);

    Route::post('/customerLogin', [MobileController::class, 'customerLogin']);
    Route::post('/customerRegister', [MobileController::class, 'customerRegister']);
    Route::get('/customerOrderHistory', [MobileController::class, 'orderHistoroy']);

    Route::post('/requestStock', [MobileController::class, 'requestStock']);
});
