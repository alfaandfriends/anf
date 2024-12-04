<?php

use App\Http\Controllers\AiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
        Route::resource('ai', AiController::class);
        Route::get('chat/{id}', [AiController::class, 'edit'])->name('chat.edit');
        Route::post('ai-helper/generate-quiz', [AiController::class, 'generateQuiz'])->name('ai.generate_quiz');
});