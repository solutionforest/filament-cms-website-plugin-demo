<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the database.sqlite.example file to be copied to database.sqlite every hour
        $schedule->call(function () {
            if (Storage::disk('database')->exists('database.sqlite.example')) {
                // Copy and override the database.sqlite.example file to database.sqlite
                Storage::disk('database')->copy('database.sqlite.example', 'database.sqlite');
            }
        })->hourly();
        // $schedule->call(fn () => Log::info('This is a scheduled task'))->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
