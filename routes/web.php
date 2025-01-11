<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify.otp-form');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp');



