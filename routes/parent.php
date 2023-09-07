<?php

use App\Http\Controllers\Parent\ArtGalleryController;
use App\Http\Controllers\Parent\AttendanceController;
use App\Http\Controllers\Parent\HomeworkController;
use App\Http\Controllers\Parent\InvoiceController;
use App\Http\Controllers\Parent\PaymentController;
use App\Http\Controllers\Parent\HomeController;
use App\Http\Controllers\Parent\StoryBookController;
use App\Http\Controllers\Parent\StudyMaterialsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function(){
    /* Onboard */
    Route::get('onboarding', [HomeController::class, 'onboarding'])->name('onboarding');
    Route::middleware(['onboard'])->prefix('/')->name('parent.')->group(function () {

        /* Home */
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::post('switch-child', [HomeController::class, 'switchChild'])->name('switch_child');

        /* Invoices */
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/callback', [InvoiceController::class, 'callback'])->name('invoices.callback');

        /* Art Gallery */
        Route::get('art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery');
        Route::post('art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store');
        Route::delete('art-gallery/delete/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy');
    });
    

    /* Art Gallery */
    Route::get('/parent/art-gallery/get-artworks', [ArtGalleryController::class, 'getArtworks'])->name('parent.art_gallery.get_artworks');
    
    /* Art Gallery Select Options */
    Route::get('/parent/art-gallery/get-levels', [ArtGalleryController::class, 'getLevels'])->name('parent.art_gallery.get_levels');
    Route::get('/parent/art-gallery/get-themes/{level_id}', [ArtGalleryController::class, 'getThemes'])->name('parent.art_gallery.get_themes');
});
