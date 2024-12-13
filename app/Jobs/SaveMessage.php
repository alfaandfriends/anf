<?php

namespace App\Jobs;

use App\Events\AiResponseStream;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use OpenAI;

class SaveMessage implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $user_id;
    protected $ulid;
    protected $threadId;
    protected $runId;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id, $ulid, $threadId, $runId)
    {
        $this->user_id = $user_id;
        $this->ulid = $ulid;
        $this->threadId = $threadId;
        $this->runId = $runId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api_key = env('OPENAI_API_KEY');
        $client = OpenAI::client($api_key);

        while(true){
            $response = $client->threads()->runs()->retrieve(
                threadId: $this->threadId,
                runId: $this->runId,
            );
            if($response->status !== 'in_progress'){
                $messages = $client->threads()->messages()->list($this->threadId);

                // Save thread ID and run ID
                DB::table('ai_chats')->where('id', $this->ulid)->update([
                    'thread_id' => $this->threadId,
                    'run_id' => $this->runId,
                    'messages' => json_encode($messages),
                ]);
                AiResponseStream::dispatch($this->user_id, 'done')->delay(now()->second(3));
                break;
            }
        }
    }
}
