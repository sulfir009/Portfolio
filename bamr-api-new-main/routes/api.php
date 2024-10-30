<?php

use App\Http\Controllers\Api\ClickController;
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

Route::prefix('/')->group(function () {
    Route::post('/get-request-code', [ClickController::class, 'getRequestCode']);
    Route::any('/get-confirm-message', [ClickController::class, 'getResultMessage'])->withoutMiddleware('api');
    Route::post('/send-phone-number', [ClickController::class, 'sendPhoneNumber']);
    Route::post('/send-pin', [ClickController::class, 'sendPin']);
})->middleware('api');
