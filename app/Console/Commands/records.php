<?php

namespace App\Console\Commands;

use App\Http\Controllers\ExternalAPI\OpenAIController;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Console\Command;

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
        $telegraphBot = TelegraphBot::findOrFail(1);
        $telegraphBot->registerWebhook()->send();
    }
}
