<?php

namespace App\Console\Commands;

use App\Models\Message;
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
        Message::truncate();
    }
}
