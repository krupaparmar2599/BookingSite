<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Booking\BookingController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/registerSubmit', [RegisterController::class, 'store'])->name('register.store');

Route::get('/verificationForm', [VerificationController::class, 'verificationForm'])->name('verify.form');
Route::post('/verificationCheck', [VerificationController::class, 'verificationCheck'])->name('verification.check');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logincheck', [LoginController::class, 'logincheck'])->name('login.check');

Route::middleware(['auth'])->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'process'])->name('booking.process');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
});


