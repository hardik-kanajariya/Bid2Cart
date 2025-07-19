<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Product;
use App\Models\User;
use App\Models\BidHistory;
use App\Models\MaxBid;
use Carbon\Carbon;

class SimulateRealTimeBidding extends Command
{
    protected $signature = 'auction:simulate-bidding {--duration=60}';
    protected $description = 'Simulate real-time bidding activity';

    public function handle()
    {
        $duration = $this->option('duration'); // Duration in minutes
        $endTime = Carbon::now()->addMinutes($duration);
        
        $this->info("Starting real-time bidding simulation for {$duration} minutes...");
        
        while (Carbon::now()->lt($endTime)) {
            $this->simulateBiddingRound();
            sleep(rand(10, 30)); // Wait 10-30 seconds between rounds
        }
        
        $this->info('Bidding simulation completed!');
    }

    private function simulateBiddingRound()
    {
        // Get active auctions with active products
        $activeProducts = Product::whereHas('auction', function($query) {
            $query->where('status', 'active')
                  ->where('end_date', '>=', Carbon::now()->format('Y-m-d'));
        })->where('auction_status', 'active')->get();

        if ($activeProducts->isEmpty()) {
            return;
        }

        // Select random products for bidding
        $productsToUpdate = $activeProducts->random(min(5, $activeProducts->count()));
        
        foreach ($productsToUpdate as $product) {
            if (rand(1, 100) <= 30) { // 30% chance of activity per product per round
                $this->placeBid($product);
            }
        }
    }

    private function placeBid($product)
    {
        $currentBid = floatval($product->current_bid);
        $retailValue = floatval($product->retail_value);
        $targetBid = $retailValue * 0.8;
        
        // Don't bid if already at target
        if ($currentBid >= $targetBid) {
            return;
        }
        
        // Get bot and regular users
        $botUsers = User::where('role', 'bot')->get();
        $regularUsers = User::where('role', '!=', 'bot')->orWhereNull('role')->get();
        
        // Determine if bot should bid (bots bid more aggressively below target)
        $shouldBotBid = $currentBid < ($targetBid * 0.7) && rand(1, 100) <= 75;
        $user = $shouldBotBid && $botUsers->isNotEmpty() ? 
                $botUsers->random() : 
                $regularUsers->random();
        
        if (!$user) {
            return;
        }
        
        // Calculate new bid
        $increment = $this->calculateBidIncrement($currentBid);
        $newBid = $currentBid + $increment;
        
        // Update previous bids to outbid
        BidHistory::where('product_id', $product->prd_id)
                  ->where('status', 'winning')
                  ->update(['status' => 'outbid']);
        
        // Create new bid
        BidHistory::create([
            'user_id' => $user->userid ?? $user->id,
            'product_id' => $product->prd_id,
            'bidder' => $user->name,
            'amount' => number_format($newBid, 2, '.', ''),
            'status' => 'winning',
        ]);
        
        // Update product current bid
        $product->update(['current_bid' => number_format($newBid, 2, '.', '')]);
        
        $this->line("New bid placed on {$product->title}: $" . number_format($newBid, 2) . " by {$user->name}");
    }

    private function calculateBidIncrement($currentBid)
    {
        if ($currentBid < 25) {
            return rand(1, 2);
        } elseif ($currentBid < 100) {
            return rand(2, 5);
        } elseif ($currentBid < 500) {
            return rand(5, 15);
        } else {
            return rand(10, 25);
        }
    }
}