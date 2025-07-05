<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\BidHistory;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\MaxBid;
use App\Models\Notification;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Support;
use App\Models\User;
use App\Models\WatchList;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Api extends Controller
{
    // Function to Create Contact Request
    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => "required|nullable",
            "lastname" => "required|nullable",
            "mobile" => "required|nullable",
            "email" => "email|required|nullable",
            "subject" => "required|nullable",
            "message" => "required|nullable"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $c = new Contact();
        $c->first_name = $request['firstname'];
        $c->last_name = $request['lastname'];
        $c->mobile = $request['mobile'];
        $c->email = $request['email'];
        $c->subject = $request['subject'];
        $c->message = $request['message'];
        $c->save();
        $response = ["status" => true, 'message' => 'Contact Received Successfully'];
        return $response;
    }

    // Function to get All Category List
    public function getAllCategory()
    {
        $cat = Category::all();
        foreach ($cat as $key) {
            // Getting products from category
            $count_products = Product::where('category_id', $key['cat_id'])->count();
            $key['category_thumbnail'] = url('/') . '/uploads/category_thumbnail/' . $key['category_thumbnail'];
            if($count_products > 0){
                $key['category_thumbnail'] = url('/') . '/uploads/category_thumbnail/' . $key['category_thumbnail'];
            }else{
                unset($cat[$key['cat_id']]);
            }
        }
        // getting category which has products
        $response = array();
        foreach ($cat as $key) {
            array_push($response, $key);
        }
        return $response;
    }

    // Function to Get Number of Products
    public function getAllProducts()
    {
        $auction = Auction::where('status', 'active')->get();
        $p = Product::where('auction_id', $auction[0]['aid'])->orderBy('updated_at', 'DESC')->paginate(6);
        $images = array();
        foreach ($p as $key) {
            $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            $imageDecode = json_decode($key['images'], true);
            $count = count($imageDecode);
            $img = array();
            for ($i = 0; $i < $count; $i++) {
                array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
            }
            array_push($images, $img);
        }

        foreach ($p as $key) {
            foreach ($images as $data) {
                $key['images'] = $data;
            }
        }
        return $p;
    }

    // Function to get Latest Products
    public function getLatestProducts()
    {
        $auction = Auction::where('status', 'active')->get();
        $p = Product::where('auction_id', $auction[0]['aid'])->orderBy('updated_at', 'DESC')->paginate(6);
        $images = array();
        foreach ($p as $key) {
            $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            $imageDecode = json_decode($key['images'], true);
            $count = count($imageDecode);
            $img = array();
            for ($i = 0; $i < $count; $i++) {
                array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
            }
            array_push($images, $img);
        }

        foreach ($p as $key) {
            foreach ($images as $data) {
                $key['images'] = $data;
            }
        }
        return $p;
    }


    // Get Filtered products by rating
    public function getFilteredProducts(Request $request)
    {
        if ($request['term'] == 'lth') {
            $auction = Auction::where('status', 'active')->get();
            $p = Product::where('auction_id', $auction[0]['aid'])->orderBy('condition_rating', 'ASC')->paginate(12);
            $images = array();
            foreach ($p as $key) {
                $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
                $imageDecode = json_decode($key['images'], true);
                $count = count($imageDecode);
                $img = array();
                for ($i = 0; $i < $count; $i++) {
                    array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
                }
                array_push($images, $img);
            }

            foreach ($p as $key) {
                foreach ($images as $data) {
                    $key['images'] = $data;
                }
            }
            return $p;
        }

        if ($request['term'] == 'htl') {
            $p = Product::where('auction_status', 'active')->orderBy('condition_rating', 'DESC')->paginate(12);
            $images = array();
            foreach ($p as $key) {
                $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
                $imageDecode = json_decode($key['images'], true);
                $count = count($imageDecode);
                $img = array();
                for ($i = 0; $i < $count; $i++) {
                    array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
                }
                array_push($images, $img);
            }

            foreach ($p as $key) {
                foreach ($images as $data) {
                    $key['images'] = $data;
                }
            }
            return $p;
        }

        return response()->json(['status' => false, 'msg' => 'Invalid Filter Request']);
    }

    // Function to get Single Products by Product Id
    public function getProductById(Request $request)
    {
        $product = Product::find($request['product_id']);
        $data = compact('product');
        $images = array();
        foreach ($data as $key) {
            $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            $imageDecode = json_decode($key['images'], true);
            $count = count($imageDecode);
            $img = array();
            for ($i = 0; $i < $count; $i++) {
                array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
            }
            array_push($images, $img);
        }

        foreach ($data as $key) {
            foreach ($images as $item) {
                $key['images'] = $item;
            }
        }
        return $data['product'];
    }

    // Function to get products by category
    public function getProductByCategory(Request $request)
    {
        $categoryName = $request['category'];
        $check = Category::where('category_name', $categoryName)->count();
        if ($check == 1) {
            $catid = Category::where('category_name', $categoryName)->get();
            $catid = $catid[0]['cat_id'];
            $auction = Auction::where('status', 'active')->get();
            $p = Product::where('category_id', $catid)->where('auction_id', $auction[0]['aid'])->orderBy('updated_at', 'DESC')->paginate(6);
            $images = array();
            foreach ($p as $key) {
                $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
                $imageDecode = json_decode($key['images'], true);
                $count = count($imageDecode);
                $img = array();
                for ($i = 0; $i < $count; $i++) {
                    array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
                }
                array_push($images, $img);
            }

            foreach ($p as $key) {
                foreach ($images as $data) {
                    $key['images'] = $data;
                }
            }
            return $p;
        } else {
            return response()->json(['msg' => "No Products Found"]);
        }
    }

    // Get LoggedIn UserData
    public function getUser()
    {
        return request()->user();
    }

    // Function to Update user Profile
    public function updateUserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstName" => 'required',
            "lastName" => 'required',
            "mobile" => 'required',
            "street" => 'required',
            "city" => 'required',
            "state" => 'required',
            "zipcode" => 'required',
            "country" => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // Getting Authenticated users id
        $user = request()->user();
        $uid = $user->userid;

        $u = User::find($uid);
        $u->first_name = $request['firstName'];
        $u->last_name = $request['lastName'];
        $u->address = $request['street'];
        $u->city = $request['city'];
        $u->state = $request['state'];
        $u->country = $request['country'];
        $u->zip = $request['zipcode'];
        $u->phone = $request['mobile'];
        $u->save();
        return response()->json(['status' => true, 'msg' => 'Profile updated successfully']);
    }

    // Function to Add Watchlist
    public function addWatchList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $pid = $request['pid'];

        // Getting Authenticated users id
        $user = request()->user();
        $uid = $user->userid;

        // Checking if product already exists or not
        $count = WatchList::where('product_id', $pid)->where('user_id', $uid)->count();
        if ($count >= 1) {
            $response = ["status" => false, 'message' => 'Product is Already in your watchlist'];
            return $response;
        }

        // Inserting new Record
        $watchlist = new WatchList();
        $watchlist->product_id = $pid;
        $watchlist->user_id = $uid;
        $watchlist->save();
        $response = ["status" => true, 'message' => 'Product added to your watchlist'];
        return $response;
    }

    // Function to fetch Watchlist
    public function getWatchList(Request $request)
    {
        $user = request()->user();
        $uid = $user->userid;
        $data = WatchList::where('user_id', $uid)->get();
        $response = array();

        foreach ($data as $key) {
            $id = $key['product_id'];
            $product = Product::find($id);
            $data = compact('product');
            $images = array();
            foreach ($data as $key) {
                $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            }
            array_push($response, $data['product']);
        }

        return $response;
    }

    // Function to remove watchlist
    public function removeWatchList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $pid = $request['pid'];

        // Getting Authenticated users id
        $user = request()->user();
        $uid = $user->userid;

        // Getting Watchlist id by product id and user id
        $watchListData = WatchList::where('product_id', $pid)->where('user_id', $uid)->get();

        // return $watchListData;
        $wid = $watchListData[0]->id;
        // return $wid;
        // Deleting record
        $watchlist = WatchList::find($wid);
        $watchlist->delete();
        $response = ["status" => true, 'message' => 'Product removed from your watchlist'];
        return $response;
    }

    // Function for ProxyBid
    public function placeProxyBid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
            "amount" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $getActiveAuction = Auction::where('status', 'active')->count();
        if (!$getActiveAuction == "1") {
            return response()->json(["msg" => "Auction Expired"]);
        }

        // Declaring All Variables
        $pid = $request['pid'];
        $amount = $request['amount'];
        $currentBidAmount = null;
        $history = null;
        $lastAmount = null;

        // Getting Logged in users details
        if (!request()->user()) {
            return response()->json(["msg" => "unauthenticated"]);
        }
        $user = request()->user();
        // $user = User::find($request['uid']); // Remove this line in production
        $uid = $user->userid;
        $bidder = $user->username;


        // Getting Current Bid Amount
        $currentBidAmount = Product::find($pid);
        $currentBidAmount = $currentBidAmount['current_bid'];

        // Checking if maxBidder is trying to bid another value less then maximum bid
        $maxBidChecker = MaxBid::where('user_id', $uid)->where('product_id', $pid)->count();
        // return $maxBidChecker;
        if ($maxBidChecker == 1) {
            $userMax = MaxBid::where('user_id', $uid)->where('product_id', $pid)->get();
            $maxBidderAmount = $userMax[0]->max_bid;
            if ($maxBidderAmount >= $amount) {
                return response()->json(['msg' => 'Sorry!, you can not update your Proxy bid!. if you placed this bid by mistake you can raise a support request']);
            }
            // return $maxBidChecker;
        }

        // Checking Expiry time
        $end = Product::find($pid);
        $end = $end->end_time;
        $distance = strtotime($end) - time();

        if ($distance <= 10) {
            return response()->json(['msg' => 'Auction Expired...']);
        }

        // If Expiry time is now less then 2 minutes
        if ($distance <= 120) {
            // Initializing a DateTime
            $datetime = new DateTime(date("Y-m-d h:i:sa", time()));
            $datetime->add(new DateInterval('PT0H2M0S'));

            // Getting the new date after addition
            $newDate = $datetime->format('Y-m-d H:i:s');

            // Placing Bid
            // if this is first entry
            $history = BidHistory::latest('created_at')->where('product_id', $pid)->first();
            $historyCount = BidHistory::where('product_id', $pid)->count();
            if ($historyCount == 0) {
                if ($amount <= $currentBidAmount) {
                    return response()->json(['msg' => 'Please!, Enter higher amount than Current bid value']);
                }
                // Inserting First record for given product
                $bid = new BidHistory();
                $bid->user_id = $uid;
                $bid->product_id = $pid;
                $bid->bidder = $bidder;
                $bid->amount = $currentBidAmount + 1;
                $bid->status = 'winning';
                $bid->save();

                // Setting Max bid amount for user
                $max = new MaxBid();
                $max->user_id = $uid;
                $max->product_id = $pid;
                $max->max_bid = $amount;
                $max->save();

                // Updating value of current bid amount
                $pData = Product::find($pid);
                $pData->current_bid = $currentBidAmount + 1;
                $pData->end_time = $newDate;
                $pData->save();
                return response()->json(['msg' => 'Bid placed Successfully']);
            }
            // if this is second entry
            else {
                // user can not bid less amount then last placed bid amount
                if ($history) {
                    $lastAmount = $history->amount;
                    if ($amount <= $lastAmount) {
                        return response()->json(['msg' => 'Please!, Enter higher amount than Current bid value']);
                    } else {
                        // Finding Highest Bidder
                        $highestBid = MaxBid::where('product_id', $pid)->max('max_bid');
                        if ($amount == $highestBid) {

                            // Updating users status to loosing
                            DB::table('bid_history')->where('product_id', $pid)->update(['status' => 'loosing']);

                            // Now Insert Proxy Bid
                            $max = MaxBid::where('max_bid', $highestBid)->where('product_id', $pid)->first();
                            $maxUser = $max->user_id;

                            // Getting Bidder name from id
                            $user = User::find($maxUser);
                            $maxBidder = $user->username;

                            // Updating value of current bid amount to highestBid with 1 increment
                            $pData = Product::find($pid);
                            $pData->current_bid = $amount;
                            $pData->end_time = $newDate;
                            $pData->save();

                            // Inserting max bid record
                            $bid = new BidHistory();
                            $bid->user_id = $maxUser;
                            $bid->product_id = $pid;
                            $bid->bidder = $maxBidder;
                            $bid->amount = $amount;
                            $bid->status = 'winning';
                            $bid->save();


                            // Inserting loosing user record
                            $bid = new BidHistory();
                            $bid->user_id = $uid;
                            $bid->product_id = $pid;
                            $bid->bidder = $bidder;
                            $bid->amount = $currentBidAmount + 1;
                            $bid->status = 'loosing';
                            $bid->save();

                            // Inserting max bid for loosing user
                            $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                            if ($max) {
                                $max->max_bid = $amount;
                                $max->save();
                            } else {
                                $max = new MaxBid();
                                $max->user_id = $uid;
                                $max->product_id = $pid;
                                $max->max_bid = $amount;
                                $max->save();
                            }
                            return response()->json(['msg' => 'Tie Happens you can set higher amount to win this']);
                        }
                        // return $highestBid;
                        if ($amount > $highestBid) {

                            // Updating users status to loosing
                            DB::table('bid_history')->where('product_id', $pid)->update(['status' => 'loosing']);

                            $bid = new BidHistory();
                            $bid->user_id = $uid;
                            $bid->product_id = $pid;
                            $bid->bidder = $bidder;
                            $bid->amount = $highestBid + 1;
                            $bid->status = 'winning';
                            $bid->save();

                            // Updating value of current bid amount
                            $pData = Product::find($pid);
                            $pData->current_bid = $highestBid + 1;
                            $pData->end_time = $newDate;
                            $pData->save();


                            // Setting Max bid amount for user
                            $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                            if ($max) {
                                $max->max_bid = $amount;
                                $max->save();
                            } else {
                                $max = new MaxBid();
                                $max->user_id = $uid;
                                $max->product_id = $pid;
                                $max->max_bid = $amount;
                                $max->save();
                            }
                            return response()->json(['msg' => 'User placed maximum bid']);
                        } else {
                            // Inserting loosing user record
                            $bid = new BidHistory();
                            $bid->user_id = $uid;
                            $bid->product_id = $pid;
                            $bid->bidder = $bidder;
                            $bid->amount = $currentBidAmount + 1;
                            $bid->status = 'loosing';
                            $bid->save();

                            // Updating value of current bid amount for loosing user
                            $pData = Product::find($pid);
                            $pData->current_bid = $currentBidAmount + 1;
                            $pData->end_time = $newDate;
                            $pData->save();

                            // ------------------------

                            $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                            if ($max) {
                                $max->max_bid = $amount;
                                $max->save();
                            } else {
                                $max = new MaxBid();
                                $max->user_id = $uid;
                                $max->product_id = $pid;
                                $max->max_bid = $amount;
                                $max->save();
                            }

                            // -------------------------

                            // Updating users status to loosing
                            DB::table('bid_history')->where('product_id', $pid)->update(['status' => 'loosing']);

                            // Getting Current Bid Amount for proxyBid
                            $currentBidAmount = Product::find($pid);
                            $currentBidAmount = $currentBidAmount['current_bid'];

                            // Now Insert Proxy Bid
                            $max = MaxBid::where('max_bid', $highestBid)->where('product_id', $pid)->first();
                            $maxUser = $max->user_id;

                            // Getting Bidder name from id
                            $user = User::find($maxUser);
                            $maxBidder = $user->username;

                            // Updating value of current bid amount to highestBid with 1 increment
                            $pData = Product::find($pid);
                            $pData->current_bid = $amount + 1;
                            $pData->end_time = $newDate;
                            $pData->save();

                            // Inserting max bid record
                            $bid = new BidHistory();
                            $bid->user_id = $maxUser;
                            $bid->product_id = $pid;
                            $bid->bidder = $maxBidder;
                            $bid->amount = $amount + 1;
                            $bid->status = 'winning';
                            $bid->save();

                            return response()->json(['msg' => 'Proxy bid Inserted']);
                        }
                    }
                }
            }
        }

        // if this is first entry
        $history = BidHistory::latest('created_at')->where('product_id', $pid)->first();
        $historyCount = BidHistory::where('product_id', $pid)->count();
        if ($historyCount == 0) {
            if ($amount <= $currentBidAmount) {
                return response()->json(['msg' => 'Please!, Enter higher amount than Current bid value']);
            }
            // Inserting First record for given product
            $bid = new BidHistory();
            $bid->user_id = $uid;
            $bid->product_id = $pid;
            $bid->bidder = $bidder;
            $bid->amount = $currentBidAmount + 1;
            $bid->status = 'winning';
            $bid->save();

            // Setting Max bid amount for user
            $max = new MaxBid();
            $max->user_id = $uid;
            $max->product_id = $pid;
            $max->max_bid = $amount;
            $max->save();

            // Updating value of current bid amount
            $pData = Product::find($pid);
            $pData->current_bid = $currentBidAmount + 1;
            $pData->save();
            return response()->json(['msg' => 'Bid placed Successfully']);
        }
        // if this is second entry
        else {
            // user can not bid less amount then last placed bid amount
            if ($history) {
                $lastAmount = $history->amount;
                if ($amount <= $lastAmount) {
                    return response()->json(['message' => 'Please!, Enter higher amount than Current bid value']);
                } else {
                    // Finding Highest Bidder
                    $highestBid = MaxBid::where('product_id', $pid)->max('max_bid');
                    if ($amount == $highestBid) {

                        // Updating users status to loosing
                        DB::table('bid_history')->where('product_id', $pid)->where('status', 'winning')->update(['status' => 'loosing']);

                        // Now Insert Proxy Bid
                        $max = MaxBid::where('max_bid', $highestBid)->where('product_id', $pid)->first();
                        $maxUser = $max->user_id;

                        // Getting Bidder name from id
                        $user = User::find($maxUser);
                        $maxBidder = $user->username;

                        // Updating value of current bid amount to highestBid with 1 increment
                        $pData = Product::find($pid);
                        $pData->current_bid = $amount;
                        $pData->save();

                        // Inserting max bid record
                        $bid = new BidHistory();
                        $bid->user_id = $maxUser;
                        $bid->product_id = $pid;
                        $bid->bidder = $maxBidder;
                        $bid->amount = $amount;
                        $bid->status = 'winning';
                        $bid->save();


                        // Inserting loosing user record
                        $bid = new BidHistory();
                        $bid->user_id = $uid;
                        $bid->product_id = $pid;
                        $bid->bidder = $bidder;
                        $bid->amount = $currentBidAmount + 1;
                        $bid->status = 'loosing';
                        $bid->save();

                        // Inserting max bid for loosing user
                        $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                        if ($max) {
                            $max->max_bid = $amount;
                            $max->save();
                        } else {
                            $max = new MaxBid();
                            $max->user_id = $uid;
                            $max->product_id = $pid;
                            $max->max_bid = $amount;
                            $max->save();
                        }
                        return response()->json(['msg' => 'Tie Happens you can set higher amount to win this']);
                    }
                    // return $highestBid;
                    if ($amount > $highestBid) {

                        // Updating users status to loosing
                        DB::table('bid_history')->where('product_id', $pid)->update(['status' => 'loosing']);

                        $bid = new BidHistory();
                        $bid->user_id = $uid;
                        $bid->product_id = $pid;
                        $bid->bidder = $bidder;
                        $bid->amount = $highestBid + 1;
                        $bid->status = 'winning';
                        $bid->save();

                        // Updating value of current bid amount
                        $pData = Product::find($pid);
                        $pData->current_bid = $highestBid + 1;
                        $pData->save();


                        // Setting Max bid amount for user
                        $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                        if ($max) {
                            $max->max_bid = $amount;
                            $max->save();
                        } else {
                            $max = new MaxBid();
                            $max->user_id = $uid;
                            $max->product_id = $pid;
                            $max->max_bid = $amount;
                            $max->save();
                        }
                        return response()->json(['msg' => 'User placed maximum bid']);
                    } else {
                        // Inserting loosing user record
                        $bid = new BidHistory();
                        $bid->user_id = $uid;
                        $bid->product_id = $pid;
                        $bid->bidder = $bidder;
                        $bid->amount = $currentBidAmount + 1;
                        $bid->status = 'loosing';
                        $bid->save();

                        // Updating value of current bid amount for loosing user
                        $pData = Product::find($pid);
                        $pData->current_bid = $currentBidAmount + 1;
                        $pData->save();

                        // ------------------------

                        $max = MaxBid::where('user_id', $uid)->where('product_id', $pid)->first();
                        if ($max) {
                            $max->max_bid = $amount;
                            $max->save();
                        } else {
                            $max = new MaxBid();
                            $max->user_id = $uid;
                            $max->product_id = $pid;
                            $max->max_bid = $amount;
                            $max->save();
                        }

                        // -------------------------

                        // Updating users status to loosing
                        DB::table('bid_history')->where('product_id', $pid)->update(['status' => 'loosing']);

                        // Getting Current Bid Amount for proxyBid
                        $currentBidAmount = Product::find($pid);
                        $currentBidAmount = $currentBidAmount['current_bid'];

                        // Now Insert Proxy Bid
                        $max = MaxBid::where('max_bid', $highestBid)->where('product_id', $pid)->first();
                        $maxUser = $max->user_id;

                        // Getting Bidder name from id
                        $user = User::find($maxUser);
                        $maxBidder = $user->username;

                        // Updating value of current bid amount to highestBid with 1 increment
                        $pData = Product::find($pid);
                        $pData->current_bid = $amount + 1;
                        $pData->save();

                        // Inserting max bid record
                        $bid = new BidHistory();
                        $bid->user_id = $maxUser;
                        $bid->product_id = $pid;
                        $bid->bidder = $maxBidder;
                        $bid->amount = $amount + 1;
                        $bid->status = 'winning';
                        $bid->save();

                        return response()->json(['msg' => 'Proxy bid Inserted']);
                    }
                }
            }
        }
    }

    // Function to get bid history
    public function getBidHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $history = BidHistory::latest('created_at')->where('product_id', $request['pid'])->get();
        return $history;
    }

    // Function to get Users bid List
    public function getMyBids()
    {
        // Getting Logged in users details
        if (!request()->user()) {
            return response()->json(["message" => "unauthenticated"]);
        }
        $user = request()->user();
        $uid = $user->userid;
        $bidProductId = BidHistory::where('user_id', $uid)->paginate(9999);
        $productData = array();
        foreach ($bidProductId as $key) {
            $pid =  $key->product_id;
            $pData = Product::find($pid);
            $data = compact('pData');
            $images = array();
            foreach ($data as $key) {
                $key->thumbnail = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            }
            $status = BidHistory::where('user_id', $uid)->where('product_id', $pid)->get();
            array_push($productData, $pData);
            // array_push($productData, , $status[0]->status);
        }

        $productData = array_values(array_unique($productData));
        return $productData;
    }

    // Function to get Dashboard Count Data
    public function dashboardData()
    {
        if (!request()->user()) {
            return response()->json(["message" => "unauthenticated"]);
        }
        $user = request()->user();
        // $user = User::find($request['uid']); // Remove this line in production
        $uid = $user->userid;
        $bidProductId = BidHistory::where('user_id', $uid)->get();

        // Declaring Count variables
        $loosingCount = 0;
        $winningcount = 0;

        $data = array();
        foreach ($bidProductId as $key) {
            $pid =  $key->product_id;
            $bidData = BidHistory::where('user_id', $uid)->where('product_id', $pid)->orderBy('created_at', 'DESC')->first();
            array_push($data, $bidData);
        }
        $data = array_unique($data);
        foreach($data as $key){
            if($key->status == "winning"){
                $winningcount++;
            }
            if($key->status == "loosing"){
                $loosingCount++;
            }
        }
        // Getting Getting Count Data
        $watchListCount = WatchList::where('user_id', $uid)->count();
        // Sending Response
        $response = ["status" => true, "watchcount" => $watchListCount, "winningcount" => $winningcount, "loosingcount" => $loosingCount];
        return $response;
    }

    // Function to get Search Results
    public function searchProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "term" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $auction = Auction::where('status', 'active')->get();
        $result = Product::where('auction_id', $auction[0]['aid'])->where('title', 'LIKE', '%' . $request['term'] . '%')->orWhere('condition_desc', 'LIKE', '%' . $request['term'] . '%')->paginate(6);
        $images = array();
        foreach ($result as $key) {
            $key['thumbnail'] = url('/') . '/uploads/product_thumbnail/' . $key['thumbnail'];
            $imageDecode = json_decode($key['images'], true);
            $count = count($imageDecode);
            $img = array();
            for ($i = 0; $i < $count; $i++) {
                array_push($img, url('/') . '/uploads/product_image/' . $imageDecode[$i]);
            }
            array_push($images, $img);
        }

        foreach ($result as $key) {
            foreach ($images as $data) {
                $key['images'] = $data;
            }
        }
        return $result;
    }

    // Function to handle pickup request
    public function requestPickup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
            "msg" => 'nullable',
            "schedule" => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // Getting Authenticated users id
        $user = request()->user();
        $username = $user->username;

        $a = Auction::where('status', 'active')->get();
        $aid = $a[0]->aid;

        $p = new Pickup();
        $p->username = $username;
        $p->aid = $aid;
        $p->product_id = $request['pid'];
        $p->message = $request['msg'];
        $p->schedule = $request['schedule'];
        $p->save();

        return response()->json(['status' => true, 'msg' => 'Pickup requested']);
    }

    // Getting App Data
    public function getAppData()
    {

        $data = Settings::find(1);
        // Privacy Policy
        $policy = $data->policy;

        // Terms & Conditions
        $terms = $data->terms;

        // Shipping Info
        $shipping = $data->shipping_info;

        // About us
        $about = $data->about_us;

        // Consignment
        $consignment = $data->consignments;

        // Account Suspension Notice
        $suspension = $data->account_suspension;

        return compact('policy', 'terms', 'shipping', 'about', 'consignment', 'suspension');
    }

    // Support Request Function
    public function requestSupport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid" => "required",
            "question" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // Getting Authenticated users id
        $user = request()->user();
        $username = $user->username;

        $s = new Support();
        $s->username = $username;
        $s->product_id = $request['pid'];
        $s->question = $request['question'];
        $s->save();

        return response()->json(['status' => true, 'msg' => 'Support requested, we will get back to you soon']);
    }

    // Get Users Notification
    public function getNotification()
    {
        // Getting Authenticated users id
        $user = request()->user();
        $uid = $user->userid;
        $username = $user->username;

        $notis = Notification::where('username', $username)->get();
        return response()->json($notis);
    }

    // Function to approve invoice acknowledgement
    public function approveAcknowledgement($number)
    {
        $in = Invoice::where('invoice_number', $number)->get();
        print_r($in);
    }

    // Function to get user invoice details
    public function getInvoice(Request $request)
    {
        // Getting Authenticated users id
        $user = request()->user();
        $uid = $user->userid;

        $invoice_data = Invoice::where('uid', $uid)->get();
        return $invoice_data;
    }
}
