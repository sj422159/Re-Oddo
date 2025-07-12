<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Items Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Item management
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    
    // Swap management
    Route::post('/swaps/request', [SwapController::class, 'request'])->name('swaps.request');
    Route::post('/swaps/redeem', [SwapController::class, 'redeem'])->name('swaps.redeem');
    Route::post('/swaps/{swap}/accept', [SwapController::class, 'accept'])->name('swaps.accept');
    Route::post('/swaps/{swap}/decline', [SwapController::class, 'decline'])->name('swaps.decline');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/items/pending', [AdminController::class, 'pendingItems'])->name('items.pending');
    Route::post('/items/{item}/approve', [AdminController::class, 'approveItem'])->name('items.approve');
    Route::post('/items/{item}/reject', [AdminController::class, 'rejectItem'])->name('items.reject');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/swaps', [AdminController::class, 'swaps'])->name('swaps.index');
});
