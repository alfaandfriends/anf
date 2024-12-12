<?php

namespace App\Jobs;

use App\Events\AiResponseStream;
use DB;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Log;
use OpenAI;

class SendPrompt implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithBroadcasting;

    protected $user_id;
    protected $ulid;
    protected $threadId;
    protected $runId;
    protected $messages;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id, $ulid, $threadId, $runId, $messages)
    {
        $this->user_id = $user_id;
        $this->ulid = $ulid;
        $this->threadId = $threadId;
        $this->runId = $runId;
        $this->messages = $messages;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api_key = env('OPENAI_API_KEY');
        $client = OpenAI::client($api_key);

        $thread = $client->threads()->messages()->create($this->threadId, [
            'role' => 'user',
            'content' => $this->messages,
        ]);

        $run = $client->threads()->runs()->createStreamed(
            threadId: $this->threadId, 
            parameters: [
                'assistant_id' => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
                'tool_choice' => [
                    'type' => 'file_search'
                ],
            ],
        );
        
        foreach($run as $response){
            if($response->event == 'thread.message.delta'){
                // AiResponseStream::dispatch($this->user_id, 'running_response');
                // AiResponseStream::dispatch($this->user_id, $response->response->delta['content'][0]['text']['value']);
            }
            if($response->event == 'thread.message.completed'){
                // AiResponseStream::dispatch($this->user_id, 'finished_response');
                SaveMessage::dispatch($this->ulid, $this->threadId, $this->runId);
                AiResponseStream::dispatch($this->user_id, 'done');
            }
        }
    }
}
