<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VerifyPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('payment/verify', [VerifyPaymentController::class, 'verify']);
    Route::get('subscription/status', [SubscriptionController::class, 'status']);
});

Route::post('register', [RegisterController::class, 'register']);
