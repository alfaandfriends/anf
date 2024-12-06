<?php

namespace App\Jobs;

use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Auth;
use Log;
use OpenAI;

class GenerateQuiz implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $ulid;

    /**
     * Create a new job instance.
     * 
     * @param string $ulid
     */
    public function __construct($ulid)
    {
        $this->ulid = $ulid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api_key = env('OPENAI_API_KEY');
        $client = OpenAI::client($api_key);

        /* Create premade prompt */
        $thread = $client->threads()->createAndRun([
            'assistant_id' => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
            'thread' => [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Generate a random quiz.',
                    ],
                ],
            ],
            'tool_choice' => [
                'type' => 'file_search'
            ]
        ]);

        $threadId = $thread->threadId;
        $runId = $thread->id;

        SaveMessage::dispatch($this->ulid, $threadId, $runId);

    }
}
