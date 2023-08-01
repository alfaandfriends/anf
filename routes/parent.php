<?php

use App\Http\Controllers\Parent\ArtGalleryController;
use App\Http\Controllers\Parent\AttendanceController;
use App\Http\Controllers\Parent\HomeworkController;
use App\Http\Controllers\Parent\InvoiceController;
use App\Http\Controllers\Parent\PaymentController;
use App\Http\Controllers\Parent\StoryBookController;
use App\Http\Controllers\Parent\StudyMaterialsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function(){
    Route::prefix('/')->name('parent.')->group(function () {
        Route::get('home', function () {
            return Inertia::render('Parent/Home');
        })->name('home');
        Route::prefix('notice')->name('notice.')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Parent/Notice/Index');
            })->name('index');
        });
        Route::prefix('invoices')->name('invoices.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');
        });
        Route::resources([
            'payments' => PaymentController::class,
            'invoices' => InvoiceController::class,
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
