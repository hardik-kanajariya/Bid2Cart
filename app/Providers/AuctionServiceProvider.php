<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuctionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\SimulateRealTimeBidding::class,
                \App\Console\Commands\MaintainAuctionActivity::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}