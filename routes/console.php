<?php

use App\Jobs\PublishScheduledArticles;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// class ScheduleCommands
// {
//     protected function schedule(Schedule $schedule)
//     {
//         $schedule->job(new PublishScheduledArticles())->everyMinute();
//     }
// }
