<?php

namespace App\Booking\Messaging;

class MessagePromptResponse
{
    public string $message;
    public string $action;

    public function __construct(string $message, string $action)
    {
        $this->message = $message;
        $this->action = $action;
    }
}
