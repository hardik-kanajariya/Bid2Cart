<?php

namespace App\Http\Controllers;

use App\Models\Auction as ModelsAuction;
use App\Models\Category;
use App\Models\Product;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Auction extends Controller
{
    // View Functions
    public function viewAuction()
    {
        $auction = ModelsAuction::all();
        $data = compact('auction');
        return view('view-auction')->with($data);
    }


    public function viewScheduleAuction()
    {
        return view('add-new-auction');
    }

    // Action Functions
    public function addAuctionSchedule(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        // Request Validation
        $request->validate([
            'start-date' => 'required|date',
            'start-time' => 'required',
            'end-date' => 'required|date',
            'end-time' => 'required'
        ]);

        // Time must be Greater then Current Time
        $endDate = $request['end-date'];
        $endTime = $request['end-time'];

        // Getting End Time
        $end = $endDate . ' ' . $endTime . ':00';
        $distance = strtotime($end) - time();
        // return $distance;
        if ($distance > 86399) {
            $au = new ModelsAuction();
            $au->start_date = $request['start-date'];
            $au->start_time = $request['start-time'];
            $au->end_date = $request['end-date'];
            $au->end_time = $request['end-time'];
            $au->save();
            return redirect('/auctions')->with('msg', 'Auction scheduled');
        } else {
            return back()->with('errmsg', 'You must have to schedule auction for at least 24 hours');
        }
    }

    public function updateAuctionSchedule(Request $request)
    {
        // Request Validation
        $request->validate([
            'aid' => 'required',
            'start-date' => 'required|date',
            'start-time' => 'required',
            'end-date' => 'required|date',
            'end-time' => 'required'
        ]);
        $id = $request['aid'];
        $startDate = $request['start-date'];
        $startTime = $request['start-time'];
        $endDate = $request['end-date'];
        $endTime = $request['end-time'];

        // Getting End Time
        $start = $startDate . ' ' . $startTime . ':00';
        $end = $endDate . ' ' . $endTime . ':00';
        $distance = strtotime($end) - time();
        if ($distance > 86399) {
            Product::where('auction_id', $id)->update(['start_time' => $start, 'end_time' => $end]);
            $au = ModelsAuction::find($id);
            $au->start_date = $request['start-date'];
            $au->start_time = $request['start-time'];
            $au->end_date = $request['end-date'];
            $au->end_time = $request['end-time'];
            $au->save();
            return back()->with('msg', 'scheduled updated');
        } else {
            return back()->with('errmsg', 'You must have to schedule auction for at least 24 hours');
        }
    }

    public function updateScheduleStatus($id, $status)
    {

        if ($status == 'active') {
            $check = ModelsAuction::where('status', 'active')->count();
            if ($check >= 1) {
                return back()->with('errmsg', 'you can not start more then one auction at same time');
            }
        }
        $au = ModelsAuction::find($id);
        $au->status = $status;
        $au->save();

        // Updating Product auction status
        $pCount = Product::where('auction_status', 'active')->orWhere('auction_status', 'pending')->orWhere('auction_status', 'done')->count();
        if ($pCount > 0) {
            DB::table('product')->where('auction_id', $id)->update(['auction_status' => $status]);
        }
        return back()->with('msg', 'Auction status updated');
    }

    public function deleteSchedule($id)
    {
        // if auction is running it can not be deleted
        $check = ModelsAuction::where('status', 'active')->where('aid', $id)->count();
        if ($check >= 1) {
            return back()->with('errmsg', 'you can not Delete Running Auctions');
        }

        // If there are no any Auction Running Auction Deleted
        $au = ModelsAuction::find($id);
        if ($au) {
            $au->delete();
            return back()->with('msg', 'Auction Deleted');
        } else {
            return back()->with('errmsg', 'Auction Not Found, Please Try Again');
        }
    }
}
