<?php

namespace App\Console\Commands;

use Carbon\Carbon;
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
        $creation_date_string = '2024-06-08 16:00:54';
        $creation_date = Carbon::create($creation_date_string)->toDateString();
        $now = Carbon::now()->toDateString();
        if ($now === $creation_date) {
            echo "yes" . "\n";
            return;
        }
        echo "no" . "\n";
    }
}
