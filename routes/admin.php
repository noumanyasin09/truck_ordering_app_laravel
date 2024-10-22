<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

    /** Profile update routes */
    Route::get('profile', [ProfileUpdateController::class, 'index'])->name('profile.index');
    Route::post('profile', [ProfileUpdateController::class, 'update'])->name('profile.update');
    Route::post('profile-password', [ProfileUpdateController::class, 'passwordUpdate'])->name('profile-password.update');

    /** orders routes */
    Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('order/edit/{id}', [OrdersController::class, 'edit'])->name('order.edit');
    Route::post('order-status/{id}', [OrdersController::class, 'changeStatus'])->name('order-status.update');
    Route::delete('order/{id}', [OrdersController::class, 'destroy'])->name('order.delete');

    /** Dashboard Route */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('email', [DashboardController::class, 'email'])->name('email');
    Route::post('sendemail', [DashboardController::class, 'sendEmail'])->name('sendemail');


});


