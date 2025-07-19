<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Product;
use Carbon\Carbon;

class MaintainAuctionActivity extends Command
{
    protected $signature = 'auction:maintain-activity';
    protected $description = 'Maintain ongoing auction activity';

    public function handle()
    {
        $this->closeExpiredAuctions();
        $this->createNewAuctions();
        $this->updateProductStatuses();
        
        $this->info('Auction activity maintenance completed!');
    }

    private function closeExpiredAuctions()
    {
        $expiredAuctions = Auction::where('status', 'active')
            ->where(function($query) {
                $query->where('end_date', '<', Carbon::now()->format('Y-m-d'))
                      ->orWhere(function($subQuery) {
                          $subQuery->where('end_date', '=', Carbon::now()->format('Y-m-d'))
                                   ->where('end_time', '<', Carbon::now()->format('H:i:s'));
                      });
            })->get();

        foreach ($expiredAuctions as $auction) {
            $auction->update(['status' => 'completed']);
            
            // Update all products in this auction
            Product::where('auction_id', $auction->aid)
                   ->update(['auction_status' => 'sold']);
        }

        $this->line("Closed {$expiredAuctions->count()} expired auctions");
    }

    private function createNewAuctions()
    {
        $activeAuctionCount = Auction::where('status', 'active')->count();
        
        if ($activeAuctionCount < 5) {
            $newAuctions = Auction::factory(2)->active()->create();
            
            foreach ($newAuctions as $auction) {
                // Create products for new auction
                Product::factory(rand(8, 15))->create([
                    'auction_id' => $auction->aid,
                ]);
            }
            
            $this->line("Created 2 new auctions with products");
        }
    }

    private function updateProductStatuses()
    {
        // Activate pending products whose auctions have started
        Product::whereHas('auction', function($query) {
            $query->where('status', 'active');
        })->where('auction_status', 'pending')
          ->update(['auction_status' => 'active']);
    }
}