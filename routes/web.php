<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingPhaseController;
use App\Http\Controllers\FundraisingWithdrawalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/category/{category}', [FrontController::class, 'category'])->name('front.category');
Route::get('/details/{fundraising:slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/support/{fundraising:slug}', [FrontController::class, 'support'])->name('front.support');
Route::get('/checkout/{fundraising:slug}/{totalAmountDonation}', [FrontController::class, 'checkout'])->name('front.checkout');
Route::post('/checkout/store/{fundraising:slug}/{totalAmountDonation}', [FrontController::class, 'store'])->name('front.store');
Route::get('/success/{donatur_id}', [FrontController::class, 'success'])->name('front.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('donaturs', DonaturController::class)->middleware('role:owner');

        Route::resource('fundraisers', FundraiserController::class);
        Route::get('fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');

        Route::resource('fundraising_withdrawals', FundraisingWithdrawalController::class);

        Route::resource('fundraising_phases', FundraisingPhaseController::class);
        Route::post('/fundraising_phases/update/{fundraising}', [FundraisingPhaseController::class, 'store'])->name('fundraising_phases.store');

        Route::resource('fundraisings', FundraisingController::class);
        Route::post('/fundraisings/active/{fundraising}', [FundraisingController::class, 'activeFundraising'])->name('fundraisings.active_fundraising');

        Route::post('/fundraiser/apply', [DashboardController::class, 'applyFundraiser'])->name('fundraiser.apply');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
