<?php

use App\Http\Controllers\AiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::resource('ai', AiController::class);
});