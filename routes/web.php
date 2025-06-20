<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserCreditController;
use App\Http\Controllers\ChatHistoryController;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/delete-history', [ChatController::class, 'deleteHistory'])->name('chat.delete-history');
    
    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Subscription
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/paypal/create', [SubscriptionController::class, 'createPayPalOrder'])->name('paypal.create');
        Route::get('/paypal/success', [SubscriptionController::class, 'paypalSuccess'])->name('paypal.success');
        Route::get('/paypal/cancel', [SubscriptionController::class, 'paypalCancel'])->name('paypal.cancel');
        Route::post('/create-stripe-session', [SubscriptionController::class, 'createStripeSession'])->name('stripe.create');
        Route::get('/stripe/success', [SubscriptionController::class, 'stripeSuccess'])->name('stripe.success');
        Route::get('/stripe/cancel', [SubscriptionController::class, 'stripeCancel'])->name('stripe.cancel');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/credits', [UserCreditController::class, 'index'])->name('admin.credits');
    Route::post('/admin/credits/update/{user}', [UserCreditController::class, 'update'])->name('admin.credits.update');
    Route::get('/admin/chat-history', [ChatHistoryController::class, 'index'])->name('admin.chat-history');
});

require __DIR__.'/auth.php';
