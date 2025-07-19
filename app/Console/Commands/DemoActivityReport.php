<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemoActivityReport extends Command
{
    protected $signature = 'demo:activity-report';
    protected $description = 'Generate demo activity report';

    public function handle()
    {
        $this->info('📊 Generating Demo Activity Report');
        $this->info('Generated at: ' . Carbon::now()->format('Y-m-d H:i:s UTC'));
        $this->line('');
        
        $this->displayAuctionStats();
        $this->displayBiddingActivity();
        $this->displayUserActivity();
        $this->displayRecentActivity();
    }
    
    private function displayAuctionStats()
    {
        $this->info('🎯 Auction Statistics:');
        
        $auctionStats = DB::table('auction')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
            
        foreach ($auctionStats as $stat) {
            $this->line("  {$stat->status}: {$stat->count}");
        }
        
        $productStats = DB::table('product')
            ->select('auction_status', DB::raw('count(*) as count'))
            ->groupBy('auction_status')
            ->get();
            
        $this->line('');
        $this->info('📦 Product Statistics:');
        foreach ($productStats as $stat) {
            $this->line("  {$stat->auction_status}: {$stat->count}");
        }
        $this->line('');
    }
    
    private function displayBiddingActivity()
    {
        $this->info('💰 Bidding Activity (Last 24 Hours):');
        
        $bidsLast24h = DB::table('bid_history')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->count();
            
        $avgBidAmount = DB::table('bid_history')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->avg('amount');
            
        $maxBid = DB::table('bid_history')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->max('amount');
            
        $this->line("  Total Bids: {$bidsLast24h}");
        $this->line("  Average Bid: $" . number_format($avgBidAmount, 2));
        $this->line("  Highest Bid: $" . number_format($maxBid, 2));
        $this->line('');
    }
    
    private function displayUserActivity()
    {
        $this->info('👥 User Activity:');
        
        $activeBidders = DB::table('bid_history')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->distinct('user_id')
            ->count();
            
        $botActivity = DB::table('bid_history')
            ->join('users', 'bid_history.user_id', '=', 'users.id')
            ->where('bid_history.created_at', '>=', Carbon::now()->subDay())
            ->where('users.role', 'bot')
            ->count();
            
        $regularActivity = $activeBidders > 0 ? $activeBidders - $botActivity : 0;
        
        $this->line("  Active Bidders (24h): {$activeBidders}");
        $this->line("  Bot Bids (24h): {$botActivity}");
        $this->line("  Regular User Bids (24h): {$regularActivity}");
        $this->line('');
    }
    
    private function displayRecentActivity()
    {
        $this->info('🕐 Recent Bidding Activity (Last 10 bids):');
        
        $recentBids = DB::table('bid_history')
            ->join('product', 'bid_history.product_id', '=', 'product.prd_id')
            ->join('users', 'bid_history.user_id', '=', 'users.id')
            ->select(
                'bid_history.amount',
                'bid_history.created_at',
                'product.title',
                'users.name',
                'users.role'
            )
            ->orderBy('bid_history.created_at', 'desc')
            ->limit(10)
            ->get();
            
        foreach ($recentBids as $bid) {
            $userType = $bid->role === 'bot' ? '[BOT]' : '[USER]';
            $time = Carbon::parse($bid->created_at)->format('H:i:s');
            $this->line("  {$time} - ${$bid->amount} on '{$bid->title}' by {$bid->name} {$userType}");
        }
    }
}