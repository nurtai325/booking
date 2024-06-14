<?php

namespace App\Console\Commands;

use App\Http\Controllers\Booking\ScheduleManager;
use App\Http\Controllers\ExternalAPI\OpenAIController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Orhanerday\OpenAi\OpenAi;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

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
        $scheduleManager = new ScheduleManager();
        $data = $scheduleManager->getAvailableSchedule(1);
        echo(json_encode($data) . "\n");
    }
}
