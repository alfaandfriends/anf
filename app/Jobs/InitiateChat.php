<?php

namespace App\Jobs;

use App\Events\AiResponseStream;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Auth;
use Log;
use OpenAI;

class InitiateChat implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $chatId;
    protected $userId;
    protected $messages;

    /**
     * Create a new job instance.
     * 
     * @param string $chatId
     */
    public function __construct($chatId, $userId, $messages)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->messages = $messages;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api_key = env('OPENAI_API_KEY');
        $client = OpenAI::client($api_key);

        $thread = $client->threads()->create([]);

        $message = $client->threads()->messages()->create($thread->id, [
            'role' => 'user',
            'content' => $this->messages,
        ]);

        $run = $client->threads()->runs()->create($thread->id, [
            "assistant_id" => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
            'tool_choice' => [
                'type' => 'file_search'
            ]
        ]);

        SaveMessage::dispatch($this->chatId, $this->userId, $thread->id, $run->id);

        DB::table('ai_chats')->where('id', $this->chatId)->update([
            'thread_id' => $thread->id
        ]);

    }
}
