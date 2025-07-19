<?php

namespace App\Console;

use App\Console\Commands\BidBot;
use App\Models\MaxBid;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        // Command\BidBot::class,
        Commands\SimulateRealTimeBidding::class,
        Commands\MaintainAuctionActivity::class,
        Commands\RestoreDemoData::class,
        Commands\DemoActivityReport::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('BidBot:run')->everyMinute();

        // Restore demo data daily at 2 AM
        $schedule->command('demo:restore-data')->daily()->at('02:00');
        
        // Maintain auction activity every 6 hours
        $schedule->command('auction:maintain-activity')->cron('0 */6 * * *');
        
        // Simulate bidding every 30 minutes during business hours (9 AM - 6 PM)
        $schedule->command('auction:simulate-bidding --duration=30')
                 ->cron('*/30 9-18 * * *');
        
        // Generate activity report twice daily
        $schedule->command('demo:activity-report')
                 ->twiceDaily(9, 18);
                 
        // Clear logs weekly
        $schedule->command('log:clear')->weekly();
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
