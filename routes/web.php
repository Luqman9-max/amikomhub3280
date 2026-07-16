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
Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');
Route::get('/checkout', [UserEventController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/my-ticket', [UserEventController::class, 'ticket'])->name('ticket');

// Rute Review Event (Dilindungi Auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/events/{event}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

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

        Route::get('transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    });
});