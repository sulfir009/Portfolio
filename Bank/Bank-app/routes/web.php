<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Inertia\Inertia;

// Ресурсные маршруты для клиентов
Route::resource('customers', CustomerController::class);

// Маршрут для массового удаления всех клиентов
Route::delete('customers/destroy-all', [CustomerController::class, 'destroyAll'])->name('customers.destroyAll');

// Маршруты для счетов клиентов
Route::prefix('customers/{customer}')->group(function () {
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
});
// Маршруты для транзакций по счетам
Route::prefix('accounts/{account}')->group(function () {
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
});

// Маршрут для главной страницы с использованием Inertia
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Маршрут для панели управления с middleware проверки аутентификации
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Группа маршрутов для профиля пользователя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Подключение маршрутов аутентификации
require __DIR__.'/auth.php';
