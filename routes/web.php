<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\CompareController;
use App\Http\Controllers\Api\AnalyticsController;
use Illuminate\Support\Facades\Route;


// ─── Guest-only Auth Routes ───────────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');   // ← was missing
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ─── Logout (auth only) ───────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Protected Routes ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard — root redirects here
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Markets
    Route::get('/markets', [MarketController::class, 'index'])->name('markets.index');
    Route::get('/markets/create', [MarketController::class, 'create'])->name('markets.create');
    Route::get('/markets/{market}', [MarketController::class, 'show'])->name('markets.show');
    Route::get('/markets/{market}/edit', [MarketController::class, 'edit'])->name('markets.edit');
    Route::post('/markets', [MarketController::class, 'store'])->name('markets.store');
    Route::put('/markets/{market}', [MarketController::class, 'update'])->name('markets.update');
    Route::delete('/markets/{market}', [MarketController::class, 'destroy'])->name('markets.destroy');

    Route::post('/markets/{market}/documents', [MarketController::class, 'storeDocument'])
        ->name('markets.documents.store');

    Route::get('/documents/download/{id}', [MarketController::class, 'downloadDocument'])
        ->name('documents.download');

    Route::delete('/documents/{id}', [MarketController::class, 'destroyDocument'])
        ->name('documents.destroy');

    // Members
    Route::resource('members', MemberController::class)->except(['show']);

    // Prices
    Route::resource('prices', PriceController::class)->except(['show']);

    // Compare
    Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Plans
    Route::get('/plans', function () {
        return view('plans');
    })->name('plans');

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});