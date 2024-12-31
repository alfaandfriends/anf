<?php

namespace App\Jobs\Ai;

use App\Events\AiResponseStream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Log;

class ProcessResponse implements ShouldQueue
{
    use Dispatchable, Queueable;

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
        $this->onQueue('ai_process_response');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->response->event === 'thread.message.created'){
            $data['thread_id'] = $this->threadId;
            $data['status'] = 'created';
            AiResponseStream::dispatch($this->userId, $data);
        }
        if($this->response->event === 'thread.message.delta'){
            $data['text'] = $this->response->response->delta['content'][0]['text']['value'];
            $data['status'] = 'processing';
            AiResponseStream::dispatch($this->userId, $data);
        }
        if($this->response->event === 'thread.message.completed'){
            Log::error('Dispatch Delta');
            SaveMessage::dispatch($this->chatId, $this->userId, $this->threadId, $this->response->response->runId);
        }
    }
}
