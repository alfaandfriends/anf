<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('ai_response_stream.{userId}', function ($user, $userId) {
    Log::error("User ID: " . $user->ID);  // Log the user ID coming from the server
    Log::error("User trying to access: " . $userId); 
    return (int) $user->ID === (int) $userId;
    // return true;
});


