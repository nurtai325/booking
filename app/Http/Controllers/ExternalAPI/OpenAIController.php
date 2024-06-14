<?php

namespace App\Http\Controllers\ExternalAPI;

use App\Http\Controllers\Booking\ScheduleManager;
use App\Http\Controllers\ValidationTrait;
use App\Models\ChatSession;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Orhanerday\OpenAi\OpenAi;
use function Laravel\Prompts\text;

class OpenAIController
{
    use ValidationTrait;

    // todo add tuning text
    private array $tuning = [
        "role" => "system",
        "content" => "",
    ];

    public function sendRequest(int $user_id, int $chat_session_id, string $message): OpenAIResponse | null
    {
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $messages = $this->getMessages($chat_session_id, $message);
        if (is_null($messages)) {
            throw new \Exception('messages are null');
        }

        $scheduleManager = new ScheduleManager();
        $schedule = $scheduleManager->getAvailableSchedule($user_id);

        $messages[] = [
            'role' => 'system',
            'content' => json_encode($schedule),
        ];

        try {
            $chat = $open_ai->chat([
                'model' => 'gpt-4o',
                'messages' => $messages,

                'temperature' => 1.0,
                'max_tokens' => 100,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            $d = json_decode($chat);
            return $this->getAction($d->choices[0]->message->content, $chat_session_id);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }

    public function getAction(string $content, int $chat_session_id): OpenAIResponse
    {
        $decodedContent = json_decode($content);

        $action = $decodedContent->action;
        $text = $decodedContent->text;

        $message = new Message();
        $message->role = 'system';
        $message->content = $content;
        $message->chat_session_id = $chat_session_id;
        $message->save();

        return new OpenAIResponse(
            $decodedContent->id,
            $action,
            $text,
            $decodedContent->name,
            $decodedContent->phone,
            $decodedContent->additional_info,
        );
    }

    public function getMessages(int $chat_session_id, $message): array | null
    {
         $returnMessages = [];

        try {
            $messages = ChatSession::findOrFail($chat_session_id)
                ->messages;

            $returnMessages[] = $this->tuning;

            foreach ($messages as $message) {
                $returnMessages[] = [
                    "role" => $message->role,
                    "content" => $message->content,
                ];
            }

            return $returnMessages;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }
}
