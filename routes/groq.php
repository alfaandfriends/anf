<?php

use App\Http\Controllers\GroqApiController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function(){
    Route::get('parent-student-stories/{student_id?}', [GroqApiController::class, 'getStudentStories'])->name('student_stories');
});
