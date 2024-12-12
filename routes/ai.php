<?php

use App\Events\AiResponseStream;
use App\Http\Controllers\AiController;
use App\Jobs\SendPrompt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
        Route::resource('ai', AiController::class);
        Route::get('chat/{id}', [AiController::class, 'edit'])->name('chat.edit');
        Route::post('ai-helperP/generate-quiz', [AiController::class, 'generateQuiz'])->name('ai.generate_quiz');
});