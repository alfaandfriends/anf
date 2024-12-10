<?php

use App\Events\AiResponseStream;
use App\Http\Controllers\AiController;
use App\Jobs\SendPrompt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
        Route::resource('ai', AiController::class);
        Route::get('chat/{id}', [AiController::class, 'edit'])->name('chat.edit');
        Route::post('ai-helper/generate-quiz', [AiController::class, 'generateQuiz'])->name('ai.generate_quiz');
        Route::get('test-stream', function(){
            Log::error('Start');  // Before the event dispatch
            AiResponseStream::dispatch('This is a test message');  // Event dispatch
            // SendPrompt::dispatch('avs', 'avs', 'avs', 'avs');
            Log::error('Event dispatched');  // After event dispatch
            Log::error('End');
        });
});