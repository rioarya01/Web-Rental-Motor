<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingDataController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LaporanBookingController;
use App\Http\Controllers\Admin\PaymentDiscountController;
use App\Http\Controllers\Admin\VehicleBrandController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\VehicleFeatureController;
use App\Http\Controllers\Admin\VehicleUnitController;
use App\Http\Controllers\Admin\VehiclesDataController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VehiclesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('booking/{booking}/payment-proof', [BookingController::class, 'showPaymentProof'])->name('booking.showProof');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register-proses', [RegisterController::class, 'register_proses'])->name('register-proses');

Route::middleware('admin')->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('home.admin');
    Route::get('admin/vehicles', [VehiclesDataController::class, 'index'])->name('vehicles-data');
    Route::post('admin/vehicles/store', [VehiclesDataController::class, 'store'])->name('vehicles-data.store');
    Route::put('admin/vehicles/{id}', [VehiclesDataController::class, 'update'])->name('vehicles-data.update');
    Route::delete('admin/vehicles/{id}', [VehiclesDataController::class, 'destroy'])->name('vehicles-data.destroy');
    
    Route::get('admin/category', [VehicleCategoryController::class, 'index'])->name('vehicle-category.index');
    Route::post('admin/category/store', [VehicleCategoryController::class, 'store'])->name('vehicle-category.store');
    Route::put('admin/category/{id}', [VehicleCategoryController::class, 'update'])->name('vehicle-category.update');
    Route::delete('admin/category/{id}', [VehicleCategoryController::class, 'destroy'])->name('vehicle-category.destroy');
    
    Route::get('admin/brand', [VehicleBrandController::class, 'index'])->name('vehicle-brand.index');
    Route::post('admin/brand/store', [VehicleBrandController::class, 'store'])->name('vehicle-brand.store');
    Route::put('admin/brand/{id}', [VehicleBrandController::class, 'update'])->name('vehicle-brand.update');
    Route::delete('admin/brand/{id}', [VehicleBrandController::class, 'destroy'])->name('vehicle-brand.destroy');

    Route::get('/admin/feature', [VehicleFeatureController::class, 'index'])->name('vehicle-feature.index');
    Route::post('/admin/feature/store', [VehicleFeatureController::class, 'store'])->name('vehicle-feature.store');
    Route::put('/admin/feature/{feature}', [VehicleFeatureController::class, 'update'])->name('vehicle-feature.update');
    Route::delete('/admin/feature/{feature}', [VehicleFeatureController::class, 'destroy'])->name('vehicle-feature.destroy');

    Route::post('/admin/unit', [VehicleUnitController::class, 'store'])->name('vehicle-unit.store');
    Route::put('/admin/unit/{unit}', [VehicleUnitController::class, 'update'])->name('vehicle-unit.update');
    Route::delete('/admin/unit/{unit}', [VehicleUnitController::class, 'destroy'])->name('vehicle-unit.destroy');
    
    Route::get('admin/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('admin/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('admin/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::put('admin/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

    Route::get('admin/booking', [BookingDataController::class, 'index'])->name('booking.index');
    Route::put('admin/booking/{id}/update-status', [BookingDataController::class, 'updateStatus'])->name('booking.updateStatus');
    Route::put('admin/booking/{id}/cancel', [BookingDataController::class, 'cancel'])->name('booking.cancel');
    Route::post('admin/booking/{id}/upload-proof', [BookingDataController::class, 'uploadProofAdmin'])->name('booking.adminUploadProof');
    Route::put('admin/booking/{id}/reject-proof', [BookingDataController::class, 'rejectProof'])->name('booking.rejectProof');

    Route::get('admin/payment-discount', [PaymentDiscountController::class, 'index'])->name('admin.payment-discount');
    Route::post('admin/payment-discount/payment', [PaymentDiscountController::class, 'updatePayment'])->name('admin.payment-discount.updatePayment');
    
    // Payment Account CRUD
    Route::post('admin/payment-discount/payment-account', [PaymentDiscountController::class, 'storePaymentAccount'])->name('admin.payment-discount.storePaymentAccount');
    Route::put('admin/payment-discount/payment-account/{paymentAccount}', [PaymentDiscountController::class, 'updatePaymentAccount'])->name('admin.payment-discount.updatePaymentAccount');
    Route::delete('admin/payment-discount/payment-account/{paymentAccount}', [PaymentDiscountController::class, 'destroyPaymentAccount'])->name('admin.payment-discount.destroyPaymentAccount');

    Route::post('admin/payment-discount/discount', [PaymentDiscountController::class, 'storeDiscount'])->name('admin.payment-discount.storeDiscount');
    Route::put('admin/payment-discount/discount/{discount}', [PaymentDiscountController::class, 'updateDiscount'])->name('admin.payment-discount.updateDiscount');
    Route::delete('admin/payment-discount/discount/{discount}', [PaymentDiscountController::class, 'destroyDiscount'])->name('admin.payment-discount.destroyDiscount');

    Route::put('admin/booking/{id}/cancel', [BookingDataController::class, 'cancel'])->name('booking.cancel');
    Route::get('admin/laporan-booking', [LaporanBookingController::class, 'index'])->name('laporan-booking.index');
});


Route::middleware('user')->group(function () {
    Route::get('user', [UserController::class, 'index'])->name('home.user');
    Route::get('user/vehicles-list', [VehiclesController::class, 'index'])->name('vehicles-list.index');
    Route::get('user/vehicle-detail/{slug}', [VehiclesController::class, 'show'])->name('vehicle-detail.show');
    // Booking Routes
    Route::get('user/booking/history', [BookingController::class, 'history'])->name('booking.history');
    Route::get('user/booking/checkout/{booking}', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('user/booking/{booking}/upload-proof', [BookingController::class, 'uploadProof'])->name('booking.uploadProof');
    Route::get('user/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('user/booking/{booking}/update', [BookingController::class, 'update'])->name('booking.update');
    Route::get('user/booking/{vehicle:slug}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('user/booking/{vehicle:slug}', [BookingController::class, 'store'])->name('booking.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/profile/password', [PasswordController::class, 'update'])->name('profile.password.update');
});
