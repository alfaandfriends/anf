<?php

use App\Classes\ArtBookHelper;
use App\Http\Controllers\Parent\ArtBookController;
use App\Http\Controllers\Parent\ChildrenController;
use App\Http\Controllers\Parent\ArtGalleryController;
use App\Http\Controllers\Parent\ClassController;
use App\Http\Controllers\Parent\InvoiceController;
use App\Http\Controllers\Parent\HomeController;
use App\Http\Controllers\Parent\MessageController;
use App\Http\Controllers\Parent\PostController;
use App\Http\Controllers\Parent\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'child'])->group(function(){
    /* Onboard */
    Route::get('onboarding', [HomeController::class, 'onboarding'])->name('onboarding');
    Route::middleware(['onboard'])->prefix('/')->name('parent.')->group(function () {
        
        /* Profile */
        Route::get('profile', [ProfileController::class, 'create'])->name('profile');
        Route::get('profile/security', [ProfileController::class, 'security'])->name('profile.security');
        Route::get('children', [ChildrenController::class, 'create'])->name('children');

        /* Home */
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::post('switch-child', [HomeController::class, 'switchChild'])->name('switch_child');
        Route::post('create-post', [PostController::class, 'createPost'])->name('create_post');
        Route::post('like-post', [PostController::class, 'likePost'])->name('like_post')->middleware('throttle:240,1');

        /* Message */
        Route::get('messages', [MessageController::class, 'index'])->name('messages');

        /* Classes */
        Route::get('class/{id}', [ClassController::class, 'index'])->name('class');

        /* Invoices */
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');

        /* Art Gallery */
        Route::get('art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery');
        Route::post('art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store');
        Route::delete('art-gallery/delete/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy');

        /* Art Gallery */
        Route::get('/art-gallery/get-artworks', [ArtGalleryController::class, 'getArtworks'])->name('art_gallery.get_artworks');
    
        /* Art Book */
        Route::get('/art-book', [ArtBookController::class, 'index'])->name('art_book');
        Route::get('/art-book/generate', [ArtBookController::class, 'generate'])->name('art_book.generate');
        
        /* Art Gallery Select Options */
        Route::get('/art-gallery/get-levels', [ArtGalleryController::class, 'getLevels'])->name('art_gallery.get_levels');
        Route::get('/art-gallery/get-themes/{level_id}', [ArtGalleryController::class, 'getThemes'])->name('art_gallery.get_themes');
    });
});
