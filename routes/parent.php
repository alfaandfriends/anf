<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function(){
    Route::prefix('/')->name('parent.')->group(function () {
        Route::get('home', function () {
            return Inertia::render('Parent/Home');
        })->name('home');
        Route::prefix('class')->name('class.')->group(function () {
            //TODO: Study Materials Page
            //TODO: Homework Page
            //TODO: Art Gallery Page
            //TODO: Storybook Page
            //TODO: Attendance Page
        });
        Route::prefix('notice')->name('notice.')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Parent/Notice/Index');
            })->name('index');
        });
        Route::prefix('payment')->name('payment.')->group(function () {
            //TODO: Payment History Page
            //TODO: Fee Invoices Page
        });
        Route::prefix('invoice')->name('invoice.')->group(function () {
            //TODO: Invoice List Page
        });
        Route::prefix('art_gallery')->name('art_gallery.')->group(function () {
            //TODO: Art Gallery List Page
        });
    });
});
