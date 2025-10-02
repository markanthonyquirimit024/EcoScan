<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CaptchaController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ShoppingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Redirect root URL to homepage
Route::get('/', function () {
    return view('home');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Captcha Routes
|--------------------------------------------------------------------------
*/
Route::get('/captcha', [CaptchaController::class, 'showCaptcha'])->name('captcha.page');
Route::get('/captcha-refresh', [CaptchaController::class, 'refreshCaptcha'])->name('captcha.show');
Route::post('/captcha-verify', [CaptchaController::class, 'verifyCaptcha'])->name('captcha.verify');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed'])
    ->name('verification.verify');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password-email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Two-Factor Authentication Routes (Require Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa', [TwoFactorController::class, 'showTwoFactorForm'])->name('2fa.index');
    Route::post('/2fa', [TwoFactorController::class, 'verifyTwoFactorCode'])->name('2fa.verify');
    Route::get('/2fa/resend', [TwoFactorController::class, 'resendTwoFactorCode'])->name('2fa.resend');
    Route::get('/2fa/send', [TwoFactorController::class, 'sendTwoFactorCode'])->name('2fa.send');
    Route::get('/2fa-challenge', [TwoFactorController::class, 'challenge'])->name('auth.two-factor.challenge');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Login + 2FA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Shopping
    Route::get('/home', [ShoppingController::class, 'index'])->name('home');
    Route::get('/product/shop', [ShoppingController::class, 'orderbtn'])->name('orderbtn');

    // Orders (User)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::delete('/my-orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/my-orders/{id}/update-address', [OrderController::class, 'updateAddress'])->name('orders.updateAddress');
    Route::get('/product/order/{slug}/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/product/order-now/{slug}', [OrderController::class, 'store'])->name('orders.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'change_password'])->name('profile.change_password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Require Login + Admin Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin', 'verified'])->prefix('admin')->group(function () {
    
    // Product Management
    Route::get('/product', [ProductController::class, 'index'])->name('product-index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');
    Route::post('/product/store', [ProductController::class, 'StoreRequest'])->name('product-store');
    Route::get('/product/{slug}', [ProductController::class, 'edit'])->name('product-edit');
    Route::put('/product/{slug}', [ProductController::class, 'update'])->name('product-update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product-destroy');

    // Order Management
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
