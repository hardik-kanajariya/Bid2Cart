<? 

    // // Functions for Bids 
    // public function addNewBid(Request $request) // This Function is not working 
    // {
    //     $validator = Validator::make($request->all(), [
    //         "pid" => "required",
    //         "amount" => "required",
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()]);
    //     }

    //     // Declaring All Variables 
    //     $pid = $request['pid'];
    //     $amount = $request['amount'];
    //     $currentBidAmount = null;
    //     $minimumBidAmount = null;
    //     $history = null;
    //     $lastAmount = null;

    //     // Bot usernames 
    //     $botBidderName = ['Fran G. Pani', 'John Quil', 'Ev R. Lasting', 'Anne Thurium', 'Glad I. Oli', 'Del Phineum', 'Frank N. Stein', 'Jay A. Castle', 'Kenneth F. Lanky', 'Patrick C. Pace', 'Charles B. Natasha', 'William C. Clem', 'Todd C. Bowman', 'Barry B. Bronson', 'Carlos A. Soto', 'Wesley B. Campbell', 'Anton J. Diana', 'Jason R. Murray', 'Edward B. Galliard', 'David M. Tomcats'];


    //     // Getting Logged in users details 
    //     $user = request()->user();
    //     $uid = $user->userid;
    //     $bidder = $user->first_name;

    //     // Getting Current Bid Value for Product 
    //     $pData = Product::find($pid);
    //     if ($pData) {
    //         $currentBidAmount = $pData->current_bid;
    //         $minimumBidAmount = $pData->minimum_bid;
    //     } else {
    //         return response()->json(['message' => 'Product not Found']);
    //     }

    //     if ($amount <= $currentBidAmount) {
    //         return response()->json(['message' => 'Amount is invalid!, Enter higher amount than current bid value']);
    //     } else {
    //         // Getting last records of bidding history 
    //         $history = BidHistory::latest('created_at')->where('product_id', $pid)->first();

    //         if ($history) {
    //             $lastAmount = $history->amount;
    //             return "History last amount " . $lastAmount;
    //             if ($amount <= $lastAmount) {
    //                 return response()->json(['message' => 'Amount is invalid!, Enter higher amount than Current bid value']);
    //             } else {
    //             }
    //         } else {
    //             // if this is first record 
    //             if ($amount >= $minimumBidAmount) {
    //                 $bid = new BidHistory();
    //                 $bid->user_id = $uid;
    //                 $bid->product_id = $pid;
    //                 $bid->bidder = $bidder;
    //                 $bid->amount = $currentBidAmount + 1;
    //                 $bid->status = 'winning';
    //                 // $bid->save();

    //                 // Storing max amount for users 
    //                 $max = new MaxBid();
    //                 $max->user_id = $uid;
    //                 $max->product_id = $pid;
    //                 $max->max_bid = $amount;
    //                 // $max->save();
    //                 return response()->json(['message' => 'Bid placed by ' . $bidder, 'minimum_bid_amount' => $minimumBidAmount, 'maximum_bid_amount' => $amount]);
    //             } else {
    //                 $bid = new BidHistory();
    //                 $bid->user_id = $uid;
    //                 $bid->product_id = $pid;
    //                 $bid->bidder = $bidder;
    //                 $bid->amount = $amount;
    //                 $bid->status = 'loosing';
    //                 // $bid->save();

    //                 // Because it his smaller amount then Minimum Bid value bot will add new record 
    //                 $bid = new BidHistory();
    //                 $bid->user_id = '5';
    //                 $bid->product_id = $pid;
    //                 $bid->bidder = $botBidderName[rand(1, 20)];
    //                 $bid->amount = $amount;
    //                 $bid->status = 'winning';
    //                 // $bid->save();
    //                 return response()->json(['message' => 'Bid placed by BidBotter']);
    //             }
    //         }
    //     }


    //     return response()->json(['message' => 'Bid placed successfully']);
    // }

    // // Function to place Bid 
    // public function placeBid(Request $request) // This is old Function 
    // {
    //     $validator = Validator::make($request->all(), [
    //         "pid" => "required",
    //         "amount" => "required",
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()]);
    //     }
    //     // Decalaring All Variables 
    //     $pid = $request['pid'];
    //     $amount = $request['amount'];
    //     $currentBidAmount = null;
    //     $history = null;
    //     $lastAmount = null;

    //     // Getting Logged in users details 
    //     $user = request()->user();
    //     $uid = $user->userid;
    //     $bidder = $user->first_name;
    //     // Getting Current Bid Value for Product 
    //     $pData = Product::find($pid);
    //     if ($pData) {
    //         $currentBidAmount = $pData->current_bid;
    //         if ($amount <= $currentBidAmount) {
    //             return response()->json(['message' => 'Amount is invalid!, Enter higher amount than Current bid value']);
    //         }
    //     }

    //     // Getting Last  value from History 
    //     $history = BidHistory::latest('created_at')->where('product_id', $pid)->first();
    //     if ($history) {
    //         $lastAmount = $history->amount;
    //         if ($amount <= $lastAmount) {
    //             return response()->json(['message' => 'Amount is invalid!, Enter higher amount than Current bid value']);
    //         } else {
    //             $history->status = 'loosing';
    //             $history->save();
    //         }
    //     }

    //     $bid = new BidHistory();
    //     $bid->user_id = $uid;
    //     $bid->product_id = $pid;
    //     $bid->bidder = $bidder;
    //     $bid->amount = $currentBidAmount + 1;
    //     $bid->status = 'winning';
    //     $bid->save();

    //     // Updating value of current bid amount 
    //     $pData->current_bid = $currentBidAmount + 1;
    //     $pData->save();

    //     // Storing max bid value for first time 
    //     // Storing max amount for users 
    //     $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->count();
    //     if ($max == 1) {
    //         // If there is already record for this user update max value  
    //         $max = MaxBid::where('user_id', $pid)->where('product_id', $pid)->first();
    //         $max->max_bid = $amount;
    //         $max->save();
    //     } else {
    //         // If this is first time user placing bid for this product create new record for max bid amount 
    //         $max = new MaxBid();
    //         $max->user_id = $uid;
    //         $max->product_id = $pid;
    //         $max->max_bid = $amount;
    //         $max->save();
    //     }

    //     return response()->json(['status' => true, 'message' => 'Bid placed by ' . $bidder, 'maximum_bid_amount' => $amount]);
    // }
