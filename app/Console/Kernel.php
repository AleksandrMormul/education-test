<?php

namespace App\Console;

use App\Services\EmailService;
use App\Console\Commands\UpdateCurrency;
use App\Services\InvoiceService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateCurrency::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::info('This is running');
            EmailService::weeklyEmail();
        })->weeklyOn(7, '15:00');

        $schedule->command('update:currency-rate')->hourly();
        //$schedule->command('update:currency-rate')->hourly();
        $schedule->call(function () {
            Log::info('Validation schedule is running');
            InvoiceService::validationInvoices();
        })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
