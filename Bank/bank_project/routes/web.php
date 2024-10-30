<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

// ��������������� �� �������� �������� �� ���������
Route::get('/', function () {
    return redirect()->route('clients.index');
});

// ����������� ��������� ��� CRUD ��������
Route::group(['middleware' => ['web']], function () {
    Route::resource('clients', ClientController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('branches', BranchController::class);
});
