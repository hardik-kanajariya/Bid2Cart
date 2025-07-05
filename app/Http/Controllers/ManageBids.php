<?php

namespace App\Http\Controllers;

use App\Models\BidHistory;
use App\Models\MaxBid;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ManageBids extends Controller
{
    // view Functions 
    public function viewProductBidHistory($productid, $productname)
    {
        $productData = Product::find($productid);
        // return $productData;
        $historyData = BidHistory::where('product_id', $productid)->orderby('created_at', 'DESC')->get();
        $userData = array();
        foreach ($historyData as $key) {
            $user = User::where('userid', $key->user_id)->get();
            array_push($userData, $user[0]->first_name);
        }

        $highestBid = 1;
        $maxBidder = 'None';
        // Getting Highest Bidder Details 
        $highestBid = MaxBid::where('product_id', $productid)->max('max_bid');
        $max = MaxBid::where('max_bid', $highestBid)->where('product_id', $productid)->first();
        if ($highestBid && $max) {
            $maxUser = $max->user_id;
            $user = User::find($maxUser);
            $maxBidder = $user->first_name . ' ' . $user->last_name;
        }
        $data = compact('historyData', 'productData', 'highestBid', 'maxBidder');
        return view('history')->with($data);
    }


    // Action Functions 
}
