<?php

namespace App\Console;

use App\Console\Commands\EmptyTmpFolder;
use App\Console\Commands\ResetASDMembership;
use App\Console\Commands\SendBirthdayEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command(ResetASDMembership::class)->cron('0 58 23 31 AUG ? *')->runInBackground();;
        $schedule->command(ResetASDMembership::class)->yearlyOn(8, 31, '23:59')->runInBackground();;
        $schedule->command(SendASDMembershipEmail::class)->yearlyOn(8, 31, '10:00')->runInBackground();;
        $schedule->command(EmptyTmpFolder::class)->dailyAt('23:59')->runInBackground();;
        $schedule->command(SendBirthdayEmail::class)->dailyAt('10:00')->runInBackground();;
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Europe/Rome';
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
