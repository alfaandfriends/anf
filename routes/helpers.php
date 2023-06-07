<?php

use App\Classes\ProgrammeHelper;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    /* File Download */
    Route::get('teacher_resources/{filename}', [DownloadController::class, 'teacherResources'])->name('download.teacher_resources');

    /* Programmes */
    Route::prefix('programmes')->group(function () {
        Route::get('get-programme-levels/{programme_id}', [ProgrammeHelper::class, 'getProgrammeLevels'])->name('get_programme_levels');
    });
});