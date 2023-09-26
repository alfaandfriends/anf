<?php

use App\Http\Controllers\DiagnosticTestController;
use Illuminate\Support\Facades\Route;

Route::prefix('diagnostic-test')->group(function () {
    Route::get('/', [DiagnosticTestController::class, 'dtMain'])->middleware('auth')->name('diagnostic_test.authenticated');
    Route::get('/public', [DiagnosticTestController::class, 'dtMain'])->name('public.diagnostic_test');
    Route::post('/start', [DiagnosticTestController::class, 'dtStart'])->name('diagnostic_test.run');
    Route::get('/new-level', [DiagnosticTestController::class, 'dtNewLevel'])->name('diagnostic_test.new_level');
    Route::post('/save-result', [DiagnosticTestController::class, 'saveDtResult'])->name('diagnostic_test.save_result');
    Route::get('/saved-result', [DiagnosticTestController::class, 'savedDtResult'])->name('diagnostic_test.saved_result');
    Route::post('/saved-result/save-status', [DiagnosticTestController::class, 'saveDtResultStatus'])->name('diagnostic_test.saved_result.save_status');
    Route::get('/saved-result/details', [DiagnosticTestController::class, 'savedDtResultDetails'])->name('diagnostic_test.saved_result.details');
    Route::get('/get-dt-categories', [DiagnosticTestController::class, 'getDtCategories'])->name('diagnostic_test.get_dt_categories');
    Route::get('/get-saved-result-info', [DiagnosticTestController::class, 'getSavedResultInfo'])->name('diagnostic_test.get_saved_result_info');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/parent.php';
