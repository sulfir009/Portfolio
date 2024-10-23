<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Inertia\Inertia;

// ��������� �������� ��� ��������
Route::resource('customers', CustomerController::class);

// ������� ��� ��������� �������� ���� ��������
Route::delete('customers/destroy-all', [CustomerController::class, 'destroyAll'])->name('customers.destroyAll');

// �������� ��� ������ ��������
Route::prefix('customers/{customer}')->group(function () {
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
});
// �������� ��� ���������� �� ������
Route::prefix('accounts/{account}')->group(function () {
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
});

// ������� ��� ������� �������� � �������������� Inertia
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ������� ��� ������ ���������� � middleware �������� ��������������
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ������ ��������� ��� ������� ������������
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ����������� ��������� ��������������
require __DIR__.'/auth.php';
