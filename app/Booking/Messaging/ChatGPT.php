<?php

namespace App\Booking\Messaging;

use App\Booking\Booking\ScheduleManager;
use App\Http\Controllers\ValidationTrait;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Orhanerday\OpenAi\OpenAi;

class ChatGPT
{
    use ValidationTrait;

    private const array MESSAGE_TUNING = [
        "role" => "system",
        "content" => MessageTuning::TEXT,
    ];

    public function sendChatPrompt(int $chat_id, string $token): MessagePromptResponse {
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $messages = $this->getMessages($chat_id, $token);
        $chat = $open_ai->chat([
            'model' => 'gpt-4o',
            'messages' => $messages,
            'temperature' => 1.0,
            'max_tokens' => 300,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $d = json_decode($chat);
        $content = $d->choices[0]->message->content;
        Log::info($content);

        $response = json_decode($content);
        $message = new Message();
        $message->role = 'assistant';
        $message->content = $response->message;
        $message->chat_id = $chat_id;
        $message->save();

        if ($response->action === 'book') {
            return new MessagePromptResponse($response->message,
                $response->action,
                $response->phone,
                $response->name,
                $response->additional_info,
                $response->booking_id,
            );
        } else if ($response->action === 'unbook') {
            return new MessagePromptResponse($response->message,
                $response->action,
                phone: $response->phone,
                booking_id: $response->booking_id,
            );

        }

        return new MessagePromptResponse($response->message, $response->action);
    }

    private function getMessages(int $chat_id, string $token): array {
        $messages = [];
        $scheduleManager = new ScheduleManager();

        $previous = Message::where('chat_id', $chat_id)
            ->orderBy('message_id', 'desc')
            ->limit(5)
            ->get()
            ->reject($this->validateCreationDate());

        $previous = $previous->reverse();

        foreach ($previous as $message) {
            $messages[] = [
                'role' => $message->role,
                'content' => $message->content,
            ];

            Log::info($message->content);
        }

        $user_id = User::where('bot', $token)->get()->first()->getKey();
        $messages[] = [
            'role' => 'system',
            'content' => json_encode($scheduleManager->getAvailableSchedule($user_id)),
        ];

        $messages[] = self::MESSAGE_TUNING;

        return $messages;
    }
}
