<?php

namespace App\Enums;

enum AiChatMessageStatus: string
{
    const NOT_STARTED = 'not_started';
    const PROCESSING = 'processing';
    const FINISHED = 'finished';
}
