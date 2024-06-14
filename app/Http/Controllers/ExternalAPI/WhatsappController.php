<?php

namespace App\Http\Controllers\ExternalAPI;

use App\Http\Controllers\Booking\BookingManager;
use App\Http\Controllers\ValidationTrait;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

// todo complete the webhook
class WhatsappController
{
    use ValidationTrait;

    public function webHook(Request $request) {
        $message = '';
        $phone = '';
        $chat_session_id = $this->getSessionId($phone);
        $user_id = User::where('phone', $phone)->getFirst()->getKey();

        $openai = new OpenAIController();
        $action = $openai->sendRequest($user_id, $chat_session_id, $message);
        if (is_null($action)) {
            throw new \Exception('openai request is null');
        }

        $bookingManager = new BookingManager();

        switch ($action->action) {
            case "Continue":
                $this->sendTextMessage('', '', $action->text);
                break;
            case "Book":
                $bookingManager->book(
                    $action->id,
                    $action->name,
                    $action->phone,
                    $action->additional_info);
                break;
            case "UnBook":
                $bookingManager->unBook($action->id);
                break;
            default:
                Log::info("ChatGPT error:");
                Log::info($action->action);
                Log::info($action->text);
        }
    }

    public function sendTextMessage(string $from, string $to, string $text) {
        $sid = env('SID');
        $token = env('TWILIO_TOKEN');

        try {
            $twilio = new Client($sid, $token);

            $twilio->messages->create(
                "whatsapp:$to", array(
                        "from" => "whatsapp:$from",
                        "body" => $text,
                    )
                );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getSessionId(string $phone): int {
        $chat_sessions = ChatSession::where('phone', $phone)
            ->get()
            ->reject($this->validateCreationDate());

        if ($chat_sessions->count() === 0) {
            $chat_session = ChatSession::create([
                'phone' => $phone,
            ]);

            return $chat_session->getKey();
        }

        return $chat_sessions->first()->getKey();
    }

    public function verify(Request $request) {
        $url = $request->getQueryString();
        $ch = "";

        $found = false;
        foreach (str_split($url) as $i) {
            if (!$found) {
                if ($i === '=') {
                    $found = true;
                    continue;
                }
            } else {
                if ($i === '&') {
                    break;
                }
            }

            if ($found) {
                $ch .= $i;
            }
        }

        return $ch;
    }
}
