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
    {
        $data = [];
        if($this->response->event === 'thread.run.created'){
            SaveMessage::dispatch($this->chatId, $this->userId, $this->threadId, $this->response->response->id);
        }
        if($this->response->event === 'thread.message.created'){
            $data['thread_id'] = $this->threadId;   
            $data['status'] = 'created';
        }
        if($this->response->event === 'thread.message.delta'){
            $data['text'] = $this->response->response->delta['content'][0]['text']['value'];
            $data['status'] = 'processing';
        }
        if($this->response->event === 'thread.message.completed'){
            $data['status'] = 'completed';
        }
        AiResponseStream::dispatch($this->userId, $data);
    }
}
