<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('trades.index');
    }
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Language switching
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Trade routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');
    Route::get('/trades/create', [TradeController::class, 'create'])->name('trades.create');
    Route::post('/trades', [TradeController::class, 'store'])->name('trades.store');
    Route::get('/trades/history', [TradeController::class, 'history'])->name('trades.history');
    Route::get('/trades/{trade}', [TradeController::class, 'show'])->name('trades.show');
    Route::put('/trades/{trade}/emotions', [TradeController::class, 'updateEmotions'])->name('trades.update-emotions');
    Route::get('/trades/{trade}/review', [TradeController::class, 'review'])->name('trades.review');
    Route::put('/trades/{trade}/review', [TradeController::class, 'completeReview'])->name('trades.complete-review');
});
