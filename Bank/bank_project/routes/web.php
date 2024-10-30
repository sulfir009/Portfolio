<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

// Перенаправление на страницу клиентов по умолчанию
Route::get('/', function () {
    return redirect()->route('clients.index');
});

// Группировка маршрутов для CRUD операций
Route::group(['middleware' => ['web']], function () {
    Route::resource('clients', ClientController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('branches', BranchController::class);
});
