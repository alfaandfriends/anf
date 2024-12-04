<?php

namespace App\Jobs;

use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log;
use OpenAI;

class SendPrompt implements ShouldQueue
{
    use Queueable;

    protected $chatId;
    protected $threadId;
    protected $messages;

    /**
     * Create a new job instance.
     */
    public function __construct($chatId, $threadId, $messages)
    {
        $this->chatId = $chatId;
        $this->threadId = $threadId;
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
            Log::info(json_encode($response->event)); // 'thread.run.created' | 'thread.run.in_progress' | .....
            Log::info(json_encode($response->response));// ThreadResponse | ThreadRunResponse | ThreadRunStepResponse | ThreadRunStepDeltaResponse | ThreadMessageResponse | ThreadMessageDeltaResponse
        }

        // $runId = $run->id;
        // while(true){
        //     $response = $client->threads()->runs()->retrieve(
        //         threadId: $this->threadId,
        //         runId: $runId,
        //     );
        //     if($response->status !== 'in_progress'){
        //         $messages = $client->threads()->messages()->list($this->threadId);

        //         // Save thread ID and run ID
        //         DB::table('ai_chats')->where('id', $this->chatId)->update([
        //             'thread_id' => $this->threadId,
        //             'messages' => json_encode($messages),
        //         ]);
        //         break;
        //     }
        // }

    }
}
