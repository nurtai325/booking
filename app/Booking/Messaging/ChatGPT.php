<?php

namespace App\Booking\Messaging;

use Orhanerday\OpenAi\OpenAi;

class ChatGPT
{
    // todo write fine tuning
    private array $tuning = [
        "role" => "system",
        "content" => "",
    ];

    public function sendPrompt() {
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $chat = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);


        var_dump($chat);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        $d = json_decode($chat);
        echo($d->choices[0]->message->content);
    }

    private function getMessages(int $chat_id) {

    }
}
