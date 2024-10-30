<?php

use App\Http\Controllers\AffiliatesController;
use App\Http\Controllers\AffiliatesInfoController;
use App\Http\Controllers\BusinessNumberController;
use App\Http\Controllers\CampaignCodeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('upload', UploadController::class);
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::resource('main', MainController::class);
    Route::resource('country', CountryController::class);
    Route::resource('business-number', BusinessNumberController::class);
    Route::resource('campaign-code', CampaignCodeController::class);
    Route::resource('keyword', KeywordController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('affiliates', AffiliatesController::class);
    Route::resource('affiliates-info', AffiliatesInfoController::class);

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
