<?php

use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\PipelineController;
use Illuminate\Support\Facades\Route;

    Route::middleware('auth')->group(function () {
        Route::prefix('crm')->group(function () {
            Route::get('/', function () {
                return redirect()->route('crm.dashboard');
            });
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('crm.dashboard');

            Route::prefix('sales')->group(function () {
                Route::get('/pipelines', [PipelineController::class, 'index'])->name('crm.sales.pipelines');
                Route::get('/pipelines/create', [PipelineController::class, 'create'])->name('crm.sales.pipelines.create');
                Route::post('/pipelines/store', [PipelineController::class, 'store'])->name('crm.sales.pipelines.store');
                Route::get('/pipelines/edit/{id}', [PipelineController::class, 'edit'])->name('crm.sales.pipelines.edit');
                Route::post('/pipelines/update', [PipelineController::class, 'update'])->name('crm.sales.pipelines.update');
                Route::delete('/pipelines/destroy/{id}', [PipelineController::class, 'destroy'])->name('crm.sales.pipelines.destroy');
            });
        });
    });