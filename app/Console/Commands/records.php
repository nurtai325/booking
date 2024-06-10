<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Orhanerday\OpenAi\OpenAi;

class records extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openaikey = env('OPENAI_API_KEY');
        $openai = new OpenAi($openaikey);

        try {
            $chat = $openai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You are a helpful assistant."
                    ],
                    [
                        "role" => "user",
                        "content" => "Who won the world series in 2020?"
                    ],
                    [
                        "role" => "assistant",
                        "content" => "The Los Angeles Dodgers won the World Series in 2020."
                    ],
                    [
                        "role" => "user",
                        "content" => "Where was it played?"
                    ],
                ],
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
            echo $d;
        } catch (\Exception $e) {
            print $e->getMessage() . "\n";
        }

    }
}
