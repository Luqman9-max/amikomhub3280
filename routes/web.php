<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController as UserEventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\PartnerController;

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [UserEventController::class, 'show'])->name('events.show');
Route::get('/checkout', [UserEventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [UserEventController::class, 'ticket'])->name('ticket');

// Rute Admin Area
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::resource('partners', PartnerController::class);
    Route::resource('events', AdminEventController::class)->except(['index']);
});