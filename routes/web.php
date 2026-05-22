<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register-proses', [RegisterController::class, 'register_proses'])->name('register-proses');

Route::middleware('admin')->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('home.admin');
});
Route::middleware('user')->group(function () {
    Route::get('user', [UserController::class, 'index'])->name('home.user');
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

    // Booking Routes
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
    Route::get('/booking/checkout/{booking}', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::get('/booking/{vehicle:slug}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{vehicle:slug}', [BookingController::class, 'store'])->name('booking.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
