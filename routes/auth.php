<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Freelancer\OnboardingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/login',
        [AuthenticatedSessionController::class, 'create']
    )->name('login');

    Route::post(
        '/login',
        [AuthenticatedSessionController::class, 'store']
    )->middleware('throttle:10,1');

    /*
    |--------------------------------------------------------------------------
    | OTP
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/verify-otp',
        [OtpController::class, 'show']
    )->name('otp.verify');

    Route::post(
        '/verify-otp',
        [OtpController::class, 'verify']
    )->name('otp.verify.submit')->middleware('throttle:10,1');

    Route::post(
        '/verify-otp/resend',
        [OtpController::class, 'resend']
    )->name('otp.resend')->middleware('throttle:3,1');

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/register',
        [RegisteredUserController::class, 'create']
    )->name('register');

    Route::post(
        '/register',
        [RegisteredUserController::class, 'store']
    )->middleware('throttle:5,1');
});

/*
|--------------------------------------------------------------------------
| Register / Become Freelancer
|--------------------------------------------------------------------------
|
| Route ini TIDAK menggunakan middleware guest.
|
| Guest:
|   /register/freelancer
|       ↓
|   Register OTP
|       ↓
|   Onboarding
|
| User yang sudah login:
|   /register/freelancer
|       ↓
|   Langsung onboarding
|
*/

Route::get(
    '/register/freelancer',
    [RegisteredUserController::class, 'createFreelancer']
)->name('freelancer.register');

/*
|--------------------------------------------------------------------------
| Freelancer Onboarding
|--------------------------------------------------------------------------
|
| User belum menjadi freelancer di tahap ini.
| Karena itu middleware hanya auth.
|
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/freelancer/onboarding',
        [OnboardingController::class, 'index']
    )->name('freelancer.onboarding');

    Route::post(
        '/freelancer/onboarding',
        [OnboardingController::class, 'update']
    )->name('freelancer.onboarding.update');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [AuthenticatedSessionController::class, 'destroy']
)
    ->middleware('auth')
    ->name('logout');
