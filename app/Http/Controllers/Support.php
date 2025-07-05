<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Support as ModelsSupport;
use Illuminate\Http\Request;

class Support extends Controller
{
    // View Functions 
    public function viewContact()
    {
        $list = Contact::all();
        $data = compact('list');
        return view('contact')->with($data);
    }

    public function viewSupportRequest()
    {
        $supports = ModelsSupport::all();
        $data = compact('supports');
        return view('support')->with($data); 
    } 

    public function viewManageSupportRequest($sid, $pid, $username)
    {
        $s = ModelsSupport::find($sid);
        $username = $s->username;
        $sid = $s->support_id;
        $question = $s->question;
        $status = $s->status;

        $p = Product::find($pid);
        $pname = $p->title;

        $notis = Notification::where('username', $username)->orderby('id', 'DESC')->get();
        $data = compact('username', 'sid', 'pid', 'status', 'pname', 'question', 'notis');
        return view('view-support')->with($data);
    }

    public function viewPickups(){
        $pickups = [];
        $a = Auction::where('status', 'active')->count();
        if($a > 0){
            $a = Auction::where('status', 'active')->get();
            $aid = $a[0]->aid;
            $pickups = Pickup::where('aid', $aid)->get();
        }
        $data = compact('pickups');
        return view('view-pickup')->with($data);
    }

    // Action Functions 
    public function updateContact($id, $stt)
    {
        $c = Contact::find($id);
        $c->status = $stt;
        $c->save();
        return back()->with('msg', 'Status Updated');
    }

    public function replyUser(Request $request){
        $request->validate([
            "sid" => "required",
            "username" => "required",
            "title" => "required",
            "message" => "required"
        ]);

        $n = new Notification();
        $n->sid = $request['sid'];
        $n->username = $request['username'];
        $n->title = $request['title'];
        $n->message = $request['message'];
        $n->save();

        return back()->with('msg', 'Notification sent Successfully');
    }

    public function managePickups($pid, $status){
        $up = Pickup::find($pid);
        $up->status = $status;
        $up->save();
        return back()->with('msg', 'Status updated');
    }
}
