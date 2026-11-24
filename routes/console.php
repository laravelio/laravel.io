<?php

use Illuminate\Support\Facades\Schedule;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

Schedule::command('schedule-monitor:sync')->dailyAt('04:56');
Schedule::command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily();
Schedule::command('lio:post-article-to-social-media')->twiceDaily(14, 18);
Schedule::command('lio:generate-sitemap')->daily()->graceTimeInMinutes(25);
Schedule::command('lio:update-article-view-counts')->twiceDaily();

if (config('lio.backups.enabled')) {
    Schedule::command('backup:run --only-db')->dailyAt('02:30')->timezone('UTC')->withoutOverlapping();
    Schedule::command('backup:clean')->dailyAt('02:35')->timezone('UTC')->withoutOverlapping();
    Schedule::command('backup:monitor')->dailyAt('02:40')->timezone('UTC')->withoutOverlapping();
}
