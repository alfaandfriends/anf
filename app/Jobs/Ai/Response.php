<?php

namespace App\Jobs\Ai;

use App\Events\AiResponseStream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class Response implements ShouldQueue
{
    use Queueable;

    protected $response;
    protected $chatId;
    protected $userId;
    protected $threadId;

    /**
     * Create a new job instance.
     */
    public function __construct($response, $chatId, $userId, $threadId)
    {
        $this->response = $response;
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->threadId = $threadId;
        $this->onQueue('ai_chat_response');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {$data = [];
        $event = $this->response->event;
    
        if ($event === 'thread.run.created') {
            SaveMessage::dispatch($this->chatId, $this->userId, $this->threadId, $this->response->response->id);
            return;
        }
    
        if (in_array($event, ['thread.message.created', 'thread.message.delta', 'thread.message.completed'])) {
            $data['status'] = match ($event) {
                'thread.message.created' => 'created',
                'thread.message.delta' => 'processing',
                'thread.message.completed' => 'completed',
            };
    
            if ($event === 'thread.message.delta') {
                $data['text'] = $this->response->response->delta['content'][0]['text']['value'];
            } else {
                $data['thread_id'] = $this->threadId;
            }
    
            AiResponseStream::dispatch($this->userId, $data);
        }
    }
}
