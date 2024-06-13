<?php

namespace App\Http\Controllers\ExternalAPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webHook(Request $request) {
        $messages = $request->json('entry.0.changes.0.value.messages');

        foreach ($messages as $message) {
            $from = $message['from'];
            $text = $message['text']['body'];

            $this->sendTextMessage($from, $text);

            Log::info('from: ', $from);
            Log::info('text: ', $text);
        }
    }

    public function sendTextMessage(string $from, string $text) {
        $token = env("WHATSAPP_TOKEN");
        if (is_null($token)) {
            Log::info('whatsapp token is null');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post(env("WHATSAPP_URL"), [
                'messaging_product' => 'whatsapp',
                'recipient' => 'individual',
                'to' => $from,
                'type' => 'text',
                'text' => [
                    'body' => $text,
                ]
            ]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
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
