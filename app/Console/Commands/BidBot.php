<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\MaxBid;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BidBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BidBot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BidBot: A bot for placing auto generated bids';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // BidBot Generated Names 
        $botBidderName = ['Fran G. Pani', 'John Quil', 'Ev R. Lasting', 'Anne Thurium', 'Glad I. Oli', 'Del Phineum', 'Frank N. Stein', 'Jay A. Castle', 'Kenneth F. Lasky', 'Patrick C. Pace', 'Charles B. Nakashima', 'William C. Clem', 'Todd C. Bowman', 'Barry B. Branson', 'Carlos A. Soto', 'Wesley B. Campbell', 'Anton J. Diana', 'Jason R. Murray', 'Edward B. Gallardo', 'David M. Tomczak'];

        // Declaring Variables
        $uid = '5';
        $bidder = $botBidderName[rand(1, 20)];
        $auctionId = null;
        // Getting Active auction id 
        $aData = Auction::where('status', 'active')->get();
        if($aData){
            Log::info($aData);
        }
        $pData = Product::all();


       
        $this->info('New Record Inserted Successfully');
        return 0;
    }
}
