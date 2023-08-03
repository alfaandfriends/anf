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
    Route::prefix('/')->name('parent.')->group(function () {
        
        /* Home */
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::post('switch_child', [HomeController::class, 'switchChild'])->name('switch_child');

        Route::prefix('notice')->name('notice.')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Parent/Notice/Index');
            })->name('index');
        });

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/callback', [InvoiceController::class, 'callback'])->name('invoices.callback');
        Route::get('/invoices/callback/redirect', [InvoiceController::class, 'callbackRedirect'])->name('invoices.callback.redirect');

        Route::resources([
            'payments' => PaymentController::class,
            'art-gallery' => ArtGalleryController::class,
            'homeworks' => HomeworkController::class,
            'study_materials' => StudyMaterialsController::class,
            'storybooks' => StoryBookController::class,
            'attendances' => AttendanceController::class,
        ]);
    });
    

    /* Art Gallery */
    Route::get('/parent/art-gallery/get-artworks', [ArtGalleryController::class, 'getArtworks'])->name('parent.art_gallery.get_artworks');
    
    /* Art Gallery Select Options */
    Route::get('/parent/art-gallery/get-levels', [ArtGalleryController::class, 'getLevels'])->name('parent.art_gallery.get_levels');
    Route::get('/parent/art-gallery/get-themes/{level_id}', [ArtGalleryController::class, 'getThemes'])->name('parent.art_gallery.get_themes');
});
