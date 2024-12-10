<?php

namespace App\Jobs;

use App\Events\AiResponseStream;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log;
use OpenAI;

class SendPrompt implements ShouldQueue
{
    use Queueable;

    protected $ulid;
    protected $threadId;
    protected $runId;
    protected $messages;

    /**
     * Create a new job instance.
     */
    public function __construct($ulid, $threadId, $runId, $messages)
    {
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
        Log::error('process job');
        // AiResponseStream::dispatch('This is a test message');
        // Once job is finished, dispatch the broadcast event
        // broadcast(new AiResponseStream($this->messages));
        // \Log::error('Job finished');
        // Log::error(broadcast(new AiResponseStream($this->ulid)));
        // broadcast(new AiResponseStream('test'));
        // AiResponseStream::dispatch('This is a test message');

        // $api_key = env('OPENAI_API_KEY');
        // $client = OpenAI::client($api_key);

        // $thread = $client->threads()->messages()->create($this->threadId, [
        //     'role' => 'user',
        //     'content' => $this->messages,
        // ]);

        // $run = $client->threads()->runs()->createStreamed(
        //     threadId: $this->threadId, 
        //     parameters: [
        //         'assistant_id' => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
        //         'tool_choice' => [
        //             'type' => 'file_search'
        //         ],
        //     ],
        // );
        
        // foreach($run as $response){
        //     // Log::info(json_encode($response));
        //     if($response->event == 'thread.message.delta'){
        //         AiResponseStream::dispatch('test');
        //         // broadcast(new AiResponseStream('test'));
        //         // Log::info(json_encode($response->response));
        //     }
        //     if($response->event == 'thread.message.completed'){
                
        //         SaveMessage::dispatch($this->ulid, $this->threadId, $this->runId);
        //     }
        // }
    }

    public function then($callback)
    {
        Log::error("Job finished, dispatching AiResponseStream event.");
        AiResponseStream::dispatch("Broadcast message");
    }
}
