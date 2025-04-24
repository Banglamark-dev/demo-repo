<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\Admin\VendorApprovalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VendorDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/choose-register', fn () => view('auth.choose-register'))->name('choose.register');
Route::get('/register/customer', [CustomerRegisterController::class, 'create'])->name('register.customer');
Route::post('/register/customer', [CustomerRegisterController::class, 'store']);
Route::get('/register/vendor', [VendorRegisterController::class, 'create'])->name('register.vendor');
Route::post('/register/vendor', [VendorRegisterController::class, 'store']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/vendors', [VendorApprovalController::class, 'index']);
    Route::post('/admin/vendors/approve/{user}', [VendorApprovalController::class, 'approve']);
});


Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    // Route::get('/admin/vendors', [VendorApprovalController::class, 'index']);
    // Route::post('/admin/vendors/approve/{user}', [VendorApprovalController::class, 'approve']);
   // Route::get('/dashboard', [DashboardController::class, 'index']);
});



require __DIR__.'/auth.php';
