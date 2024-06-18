<?php

namespace App\Http\Controllers;

use App\Booking\Booking\BookingManager;
use App\Booking\Messaging\ChatGPT;
use App\Booking\Messaging\TelegramAPI;
use App\Models\Message;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Facades\Log;

class WebHookController extends WebhookHandler
{
    protected function handleChatMessage(\Stringable $text): void
    {
        $chat_id = $this->chat->chat_id;

        $message = new Message();
        $message->chat_id = $chat_id;
        $message->content = $text;
        $message->role = 'user';
        $message->save();

        $chatGPT = new ChatGPT();
        $response = $chatGPT->sendChatPrompt($chat_id, $this->bot->token);

        $action = $response->action;
        $message = $response->message;

        switch ($action) {
            case "continue":
                $this->chat->html($message)->send();
                break;
            case "book":
                $bookingManager = new BookingManager();
                $bookingManager->book(
                    $response->booking_id,
                    $response->name,
                    $response->phone,
                    $response->additional_info,
                );
                $this->chat->html($message)->send();
                break;
            case "unbook":
                $bookingManager = new BookingManager();
                $bookingManager->unBook(
                    $response->booking_id,
                    $response->phone);
                $this->chat->html($message)->send();
                break;
            default:
                Log::info('chatgpt error');
                var_dump($response);
        }
    }
}
