<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RestoreDemoData extends Command
{
    protected $signature = 'demo:restore-data {--fresh : Run fresh migration}';
    protected $description = 'Restore demo auction data daily';

    public function handle()
    {
        $this->info('🔄 Starting demo data restoration...');
        
        if ($this->option('fresh')) {
            $this->info('🗃️ Running fresh migration...');
            Artisan::call('migrate:fresh', ['--force' => true]);
        }
        
        // Clear existing demo data but keep essential records
        $this->clearDemoData();
        
        // Reseed demo data
        $this->info('📊 Seeding fresh demo data...');
        Artisan::call('db:seed', [
            '--class' => 'AuctionDemoSeeder',
            '--force' => true
        ]);
        
        // Clear caches
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        
        $this->info('✅ Demo data restoration completed!');
        
        // Display statistics
        $this->displayStatistics();
    }
    
    private function clearDemoData()
    {
        $this->info('🧹 Clearing existing demo data...');
        
        DB::transaction(function () {
            // Clear auction-related data in correct order
            DB::table('invoice')->delete();
            DB::table('results')->delete();
            DB::table('pickup')->delete();
            DB::table('max_bid')->delete();
            DB::table('bid_history')->delete();
            DB::table('product')->delete();
            DB::table('auction')->delete();
            
            // Clear demo users (keep admin users)
            DB::table('users')->whereNotIn('email', [
                'admin@auction.com',
                'superadmin@auction.com'
            ])->delete();
            
            // Clear stores
            DB::table('stores')->delete();
        });
        
        $this->info('✅ Demo data cleared');
    }
    
    private function displayStatistics()
    {
        $stats = [
            'Users' => DB::table('users')->count(),
            'Bot Users' => DB::table('users')->where('role', 'bot')->count(),
            'Auctions' => DB::table('auction')->count(),
            'Active Auctions' => DB::table('auction')->where('status', 'active')->count(),
            'Products' => DB::table('product')->count(),
            'Active Products' => DB::table('product')->where('auction_status', 'active')->count(),
            'Total Bids' => DB::table('bid_history')->count(),
            'Stores' => DB::table('stores')->count(),
        ];
        
        $this->info('📈 Current Statistics:');
        foreach ($stats as $key => $value) {
            $this->line("  {$key}: {$value}");
        }
    }
}