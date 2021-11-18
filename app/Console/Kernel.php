<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('schedule-monitor:sync')->dailyAt('04:56');
        $schedule->command('schedule-monitor:clean')->daily();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('post-article-to-twitter')->twiceDaily(14, 18);
        $schedule->command('sitemap:generate')->daily()->graceTimeInMinutes(25);
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
