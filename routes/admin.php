<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\ProfileUpdateController;



Route::group(
    [
        'middleware' => ['guest:admin'],
        'prefix' => 'admin',
        'as' => 'admin.'
    ],
    function () {

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
    }
);
Route::group(
    [
        'middleware' => ['auth:admin'],
        'prefix' => 'admin',
        'as' => 'admin.'
    ],
    function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        /** Profile update routes */
        Route::controller(ProfileUpdateController::class)
            ->name('profile.')
            ->group(function () {

                Route::get('profile', 'index')->name('index');
                Route::post('profile', 'update')->name('update');

            });

        Route::post('profile-password', [ProfileUpdateController::class, 'passwordUpdate'])->name('profile-password.update');

    }
);
