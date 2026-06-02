<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController as UserEventController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\PartnerController;

// ─────────────────────────────────────────
// Rute User Area (Publik)
// ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [UserEventController::class, 'show'])->name('events.show');
Route::get('/checkout', [UserEventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [UserEventController::class, 'ticket'])->name('ticket');

// ─────────────────────────────────────────
// Rute Admin Area (Grouping prefix /admin)
// ─────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute Login & Logout — bebas akses (tanpa middleware auth)
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Rute administrasi — dilindungi middleware auth + admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);

        Route::get('transactions', [DashboardController::class, 'transactions'])->name('transactions');
    });
});