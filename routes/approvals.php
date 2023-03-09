<?php

use App\Classes\CentreHelper;
use App\Classes\ClassHelper;
use App\Classes\ProgrammeHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Approval\CentreApprovalController;
use App\Http\Controllers\Approval\ClassApprovalController;
use App\Http\Controllers\Approval\ProgrammeApprovalController;

Route::middleware(['auth'])->group(function(){
    /* Centre Approval */
    Route::prefix('centre_approval')->group(function () {
        Route::get('info/{id}', [CentreHelper::class, 'getCentreInfo'])->name('get_approval_centre_info');
        Route::post('centre_update/approve', [CentreApprovalController::class, 'approveCentreUpdate'])->name('approve_centre_update');
        Route::post('centre_update/reject', [CentreApprovalController::class, 'rejectCentreUpdate'])->name('reject_centre_update');
        Route::post('centre_delete/approve', [CentreApprovalController::class, 'approveCentreDelete'])->name('approve_centre_delete');
        Route::post('centre_delete/reject', [CentreApprovalController::class, 'rejectCentreDelete'])->name('reject_centre_delete');
    });

    /* Programme Approval */
    Route::prefix('programme_approval')->group(function () {
        Route::get('info/{id}', [ProgrammeHelper::class, 'getProgrammeName'])->name('get_programme_name');
        Route::post('programme_update/approve', [ProgrammeApprovalController::class, 'approveProgrammeUpdate'])->name('approve_programme_update');
        Route::post('programme_update/reject', [ProgrammeApprovalController::class, 'rejectProgrammeUpdate'])->name('reject_programme_update');
        Route::post('programme_delete/approve', [ProgrammeApprovalController::class, 'approveProgrammeDelete'])->name('approve_programme_delete');
        Route::post('programme_delete/reject', [ProgrammeApprovalController::class, 'rejectProgrammeDelete'])->name('reject_programme_delete');
    });

    /* Class Approval */
    Route::prefix('class_approval')->group(function () {
        Route::get('info/{id}', [ClassHelper::class, 'getClassInfo'])->name('get_class_info');
        Route::post('class_update/approve', [ClassApprovalController::class, 'approveClassUpdate'])->name('approve_class_update');
        Route::post('class_update/reject', [ClassApprovalController::class, 'rejectClassUpdate'])->name('reject_class_update');
        Route::post('class_delete/approve', [ClassApprovalController::class, 'approveClassDelete'])->name('approve_class_delete');
        Route::post('class_delete/reject', [ClassApprovalController::class, 'rejectClassDelete'])->name('reject_class_delete');
    });
});