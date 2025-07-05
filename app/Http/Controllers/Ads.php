<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Ads extends Controller
{
    // View Function
    public function viewAds()
    {
        $ads = Advertisement::all();
        $data = compact('ads');
        return view('manage-invoice-ads')->with($data);
    }
    // Action Functions
    public function insertNewAdvertisement(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'link' => 'url|nullable'
        ]);
        $adImage = "";
        if ($file = $request->hasFile('image')) {
            $file = $request->file('image');
            $adImage = 'ads_' . time() . '_' . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/advertisements';
            $file->move($destinationPath, $adImage);
        }

        $ad = new Advertisement();
        $ad->image = $adImage;
        $ad->link = $request['link'];
        $ad->save();

        return back()->with('msg', 'Advertisement Inserted');
    }

    public function updateAdsStatus($id, $status)
    {

        // Preventing From updating Default Ads
        if ($id == '1' || $id == 1) {
            return back()->with('msg', 'Sorry you can not update default...');
        }
        $new = Advertisement::find($id);
        $new->status = $status;
        $new->save();
        return back()->with('msg', 'Status Updated');
    }

    public function deleteAds($id, $img)
    {
        // Preventing From deleting Default Ads
        if ($id == '1' || $id == 1) {
            return back()->with('msg', 'Sorry you can not delete default...');
        }
        File::delete(public_path('/uploads/advertisements/' . $img));
        $new = Advertisement::find($id);
        $new->delete();
        return back()->with('msg', 'Advertisement Deleted');
    }
}
