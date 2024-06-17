<?php

namespace App\Booking\Messaging;

use Illuminate\Support\Facades\Log;
use Orhanerday\OpenAi\OpenAi;

class ChatGPT
{
    // todo write fine tuning
    private const array MESSAGE_TUNING = [
        "role" => "system",
        "content" => "",
    ];

    public function sendPrompt(int $chat_id, string $message):MessagePromptResponse {
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $chat = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [],
            'temperature' => 1.0,
            'max_tokens' => 150,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $d = json_decode($chat);
        $content = $d->choices[0]->message->content;

        $response = json_decode($d->choices[0]->message->content);
        return new MessagePromptResponse($response->message, $response->action);
    }

    private function getMessages(int $chat_id, string $message) {

    }
}
