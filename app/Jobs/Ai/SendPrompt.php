<?php

namespace App\Jobs\Ai;

use App\Enums\AiChatMessageStatus;
use App\Events\AiResponseStream;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenAI;

class SendPrompt implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithBroadcasting;

    protected $assistantId;
    protected $chatId;
    protected $userId;
    protected $threadId;
    protected $messages;

    /**
     * Create a new job instance.
     */
    public function __construct($assistantId, $chatId, $userId, $threadId, $messages)
    {
        $this->assistantId = $assistantId;
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->threadId = $threadId;
        $this->messages = $messages;
        $this->onQueue('ai_send_prompt');
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
                "assistant_id" => $this->assistantId,
                'tool_choice' => [
                    'type' => 'file_search'
                ]
            ]
        );

        foreach($run as $response){
            ProcessResponse::dispatchSync($response, $this->chatId, $this->userId, $thread->id);
        }

        DB::table('ai_chat_messages')->insert([
            'id' => Str::ulid(),
            'chat_id' => (string)$this->chatId,
            'prompt' => $this->messages,
            'status' => AiChatMessageStatus::PROCESSING,
        ]);
    }
}
