<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\ContactSupportController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('register', [RegisteredUserController::class, 'create'])
//             ->name('register');

// Route::post('register', [RegisteredUserController::class, 'store']);

Route::middleware('guest')->group(function () {

    /****************************************************** Admin **********************************************************/
    Route::get('admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'storeAdmin']);

    Route::get('admin/forgot-password', [PasswordResetLinkController::class, 'createAdmin'])->name('admin.password.request');


    /****************************************************** Parent **********************************************************/
    Route::get('/', [AuthenticatedSessionController::class, 'create']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

    
    /****************************************************** CRM **********************************************************/
    Route::get('crm/login', [AuthenticatedSessionController::class, 'createCRM'])->name('crm.login');

    Route::post('crm/login', [AuthenticatedSessionController::class, 'storeCRM']);

    Route::get('crm/forgot-password', [PasswordResetLinkController::class, 'createCRM'])->name('crm.password.request');


    /****************************************************** Shared **********************************************************/

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    
    Route::get('contact-support', [ContactSupportController::class, 'create'])->name('contact.support');
            
});

Route::middleware('auth')->group(function () {
    /****************************************************** CRM **********************************************************/
    Route::post('/crm/logout', [AuthenticatedSessionController::class, 'destroyCRM'])->name('crm.logout');

    /****************************************************** Admin **********************************************************/
    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroyAdmin'])->name('admin.logout');

    /****************************************************** Parent **********************************************************/
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /****************************************************** Shared **********************************************************/
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('admin.verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('admin.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('admin.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('admin.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);      
});

