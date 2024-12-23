<?php

namespace App\Jobs;

use App\Enums\AiChatMessageStatus;
use App\Events\AiResponseStream;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Log;
use OpenAI;

class SaveMessage implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $chatId;
    protected $userId;
    protected $threadId;
    protected $runId;

    /**
     * Create a new job instance.
     */
    public function __construct($chatId, $userId, $threadId, $runId)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
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
            
            if($response->status == 'completed'){
                $response = $client->threads()->messages()->list($this->threadId);

                DB::table('ai_chat_messages')->where('chat_id', $this->chatId)
                    ->orderBy('id','desc')
                    ->take(1)
                    ->update([
                        'response' => $response->data[0]['content'][0]['text']['value'],
                        'status' => AiChatMessageStatus::COMPLETED,
                    ]);
                break;
            }
            
            sleep(1); // Wait for 2 seconds before checking again
        }
    }
}
