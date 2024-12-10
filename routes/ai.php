<?php

use App\Events\AiResponseStream;
use App\Http\Controllers\AiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
        Route::resource('ai', AiController::class);
        Route::get('chat/{id}', [AiController::class, 'edit'])->name('chat.edit');
        Route::post('ai-helper/generate-quiz', [AiController::class, 'generateQuiz'])->name('ai.generate_quiz');
        Route::get('test-stream', function(){
            broadcast(new AiResponseStream('This is a test message'));
            // AiResponseStream::dispatch('This is a test message');
        });
});