<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Product;
use App\Models\User;
use App\Models\BidHistory;
use App\Models\MaxBid;
use App\Models\Stores;
use App\Models\Invoice;
use App\Models\Result;
use Carbon\Carbon;

class AuctionDemoSeeder extends Seeder
{
    public function run()
    {
        // Create stores first
        $this->createStores();
        
        // Create bot users
        $botUsers = $this->createBotUsers();
        
        // Create regular users
        $regularUsers = $this->createRegularUsers();
        
        // Create auctions
        $auctions = $this->createAuctions();
        
        // Create products for each auction
        $products = $this->createProducts($auctions);
        
        // Simulate bidding activity
        $this->simulateBiddingActivity($products, $botUsers, $regularUsers);
        
        // Create completed auction results
        $this->createCompletedAuctionResults($auctions, $products, $regularUsers, $botUsers);
        
        $this->command->info('Demo data seeded successfully!');
    }

    private function createStores()
    {
        Stores::factory(5)->create();
        $this->command->info('Created 5 stores');
    }

    private function createBotUsers()
    {
        // Create 50 bot users
        $botUsers = User::factory(50)->bot()->create();
        $this->command->info('Created 50 bot users');
        return $botUsers;
    }

    private function createRegularUsers()
    {
        // Create 20 regular users
        $regularUsers = User::factory(20)->create();
        $this->command->info('Created 20 regular users');
        return $regularUsers;
    }

    private function createAuctions()
    {
        // Create 15 auctions with different statuses
        $activeAuctions = Auction::factory(8)->active()->create();
        $completedAuctions = Auction::factory(5)->completed()->create();
        $pendingAuctions = Auction::factory(2)->create(['status' => 'pending']);
        
        $auctions = $activeAuctions->concat($completedAuctions)->concat($pendingAuctions);
        $this->command->info('Created 15 auctions (8 active, 5 completed, 2 pending)');
        return $auctions;
    }

    private function createProducts($auctions)
    {
        $products = collect();
        
        foreach ($auctions as $auction) {
            // Create 5-12 products per auction
            $productCount = rand(5, 12);
            $auctionProducts = Product::factory($productCount)->create([
                'auction_id' => $auction->aid,
            ]);
            
            $products = $products->concat($auctionProducts);
        }
        
        $this->command->info('Created ' . $products->count() . ' products across all auctions');
        return $products;
    }

    private function simulateBiddingActivity($products, $botUsers, $regularUsers)
    {
        $allUsers = $botUsers->concat($regularUsers);
        
        foreach ($products as $product) {
            $auction = Auction::find($product->auction_id);
            
            // Skip if auction is pending
            if ($auction->status === 'pending') {
                continue;
            }
            
            // Determine number of bids for this product
            $bidCount = rand(3, 25);
            $currentBid = floatval($product->minimum_bid);
            $targetBid = floatval($product->retail_value) * 0.7; // Target 70% of retail value
            
            $bidHistory = [];
            $maxBids = [];
            
            for ($i = 0; $i < $bidCount; $i++) {
                // Determine if this should be a bot bid or regular user bid
                $isBot = ($currentBid < $targetBid && rand(1, 100) <= 70) || rand(1, 100) <= 30;
                $user = $isBot ? $botUsers->random() : $regularUsers->random();
                
                // Calculate bid increment
                $increment = $this->calculateBidIncrement($currentBid);
                $newBid = $currentBid + $increment;
                
                // Create bid history
                $bidHistory[] = [
                    'user_id' => $user->userid ?? $user->id,
                    'product_id' => $product->prd_id,
                    'bidder' => $user->username ?? $user->email,
                    'amount' => number_format($newBid, 2, '.', ''),
                    'status' => $i === $bidCount - 1 ? 'winning' : 'outbid',
                    'created_at' => Carbon::now()->subMinutes(rand(1, 10080)), // Random time in last week
                    'updated_at' => Carbon::now(),
                ];
                
                // Create max bid (for proxy bidding)
                if (rand(1, 100) <= 60) { // 60% chance of setting max bid
                    $maxBidAmount = $newBid + rand(5, 50);
                    $maxBids[] = [
                        'user_id' => $user->userid ?? $user->id,
                        'product_id' => $product->prd_id,
                        'max_bid' => $maxBidAmount,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                
                $currentBid = $newBid;
                
                // Stop if we've reached a good price
                if ($currentBid >= $targetBid) {
                    break;
                }
            }
            
            // Update product current bid
            $product->update(['current_bid' => number_format($currentBid, 2, '.', '')]);
            
            // Insert bid history and max bids
            if (!empty($bidHistory)) {
                BidHistory::insert($bidHistory);
            }
            if (!empty($maxBids)) {
                MaxBid::insert($maxBids);
            }
        }
        
        $this->command->info('Simulated bidding activity for all products');
    }

    private function calculateBidIncrement($currentBid)
    {
        if ($currentBid < 25) {
            return 1;
        } elseif ($currentBid < 100) {
            return rand(2, 5);
        } elseif ($currentBid < 500) {
            return rand(5, 15);
        } else {
            return rand(10, 25);
        }
    }

    private function createCompletedAuctionResults($auctions, $products, $regularUsers, $botUsers)
    {
        $completedAuctions = $auctions->where('status', 'completed');
        $allUsers = $regularUsers->concat($botUsers);
        
        foreach ($completedAuctions as $auction) {
            $auctionProducts = $products->where('auction_id', $auction->aid);
            
            foreach ($auctionProducts as $product) {
                $lastBid = BidHistory::where('product_id', $product->prd_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                if ($lastBid) {
                    // Create result entry
                    Result::create([
                        'auction_id' => $auction->aid,
                        'user_id' => $lastBid->user_id,
                        'product_id' => $product->prd_id,
                        'result' => 'won',
                    ]);
                    
                    // Create invoice for won items
                    $winner = $allUsers->where('id', $lastBid->user_id)->first() ?? 
                             $allUsers->where('userid', $lastBid->user_id)->first();
                    
                    if ($winner) {
                        Invoice::create([
                            'aid' => $auction->aid,
                            'uid' => $lastBid->user_id,
                            'pid' => $product->prd_id,
                            'sid' => rand(1, 5), // Random store
                            'bid' => $lastBid->amount,
                            'invoice_number' => 'INV-' . strtoupper(uniqid()),
                            'invoice_total' => $lastBid->amount,
                            'product_name' => $product->title,
                            'winning_amount' => $lastBid->amount,
                            'first_name' => explode(' ', $winner->name)[0],
                            'last_name' => explode(' ', $winner->name)[1] ?? '',
                            'username' => $winner->email,
                            'acknowledgement' => rand(1, 100) <= 80 ? 'accepted' : 'pending',
                        ]);
                    }
                }
            }
        }
        
        $this->command->info('Created results and invoices for completed auctions');
    }
}