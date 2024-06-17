<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Http\Request;

class WebHookController extends WebhookHandler
{
    protected function handleChatMessage(\Stringable $text): void
    {
        // in this example, a received message is sent back to the chat
        $this->chat->html("Received: $text")->send();
    }
}
