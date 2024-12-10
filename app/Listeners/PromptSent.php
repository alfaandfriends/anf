<?php

namespace App\Listeners;

use App\Events\AiResponseStream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PromptSent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AiResponseStream $event): void
    {
        // Log job completion for debugging
        Log::info("Job ended for: " . get_class($event));

        // Dispatch the AiResponseStream event with ShouldBroadcastNow
        $chunk = "Broadcast message after job ends!";
        AiResponseStream::dispatch($chunk);
    }
}
