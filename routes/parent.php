<?php

use App\Classes\ArtBookHelper;
use App\Classes\ArtGalleryHelper;
use App\Classes\InvoiceHelper;
use App\Classes\ProgressReportHelper;
use App\Classes\StoryHelper;
use App\Http\Controllers\Parent\ArtBookController;
use App\Http\Controllers\Parent\ChildrenController;
use App\Http\Controllers\Parent\ArtGalleryController;
use App\Http\Controllers\Parent\InvoiceController;
use App\Http\Controllers\Parent\HomeController;
use App\Http\Controllers\Parent\MessageController;
use App\Http\Controllers\Parent\PostController;
use App\Http\Controllers\Parent\ProfileController;
use App\Http\Controllers\Parent\ProgressReportController;
use App\Http\Controllers\Parent\StoryController;
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
        Route::post('create-post', [StoryHelper::class, 'createPost'])->name('create_post');
        Route::post('like-story', [StoryHelper::class, 'likeStory'])->name('like_story')->middleware('throttle:240,1');

        /* Message */
        Route::get('messages', [MessageController::class, 'index'])->name('messages');

        /* Stories */
        Route::get('stories/{id}', [StoryController::class, 'index'])->name('stories');
        Route::post('/stories/comments/store', [StoryHelper::class, 'commentStory'])->name('stories.comments.store');

        /* Progress Reports */
        Route::get('progress-reports', [ProgressReportController::class, 'index'])->name('progress_reports');

        /* Invoices */
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');

        /* Art Gallery */
        Route::get('art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery');
        Route::post('art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store');
        Route::delete('art-gallery/delete/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy');
        Route::get('art-gallery/get-artworks', [ArtGalleryController::class, 'getArtworks'])->name('art_gallery.get_artworks');
    
        /* Art Book */
        Route::get('/art-book', [ArtBookController::class, 'index'])->name('art_book');
        Route::get('/art-book/generate', [ArtBookController::class, 'generate'])->name('art_book.generate');
        
        /* Art Gallery Select Options */
        Route::get('/art-gallery/get-levels', [ArtGalleryController::class, 'getLevels'])->name('art_gallery.get_levels');
        Route::get('/art-gallery/get-themes/{level_id}', [ArtGalleryController::class, 'getThemes'])->name('art_gallery.get_themes');

        /* Get Data */
        Route::get('parent-student-stories/{student_id?}', [StoryHelper::class, 'getStudentStories'])->name('student_stories');
        Route::get('student-progress-reports', [ProgressReportHelper::class, 'getStudentProgressReports'])->name('student_progress_reports');
        Route::get('student-invoices', [InvoiceHelper::class, 'getStudentFeeInvoices'])->name('student_invoices');
        Route::get('student-artworks/{levels}', [ArtGalleryHelper::class, 'getStudentArtworks'])->name('student_artworks');
    });
});
