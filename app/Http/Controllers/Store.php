<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use Illuminate\Http\Request;

class Store extends Controller
{
    // View Functions
    public function viewStores(){
        $stores = Stores::all();
        $data = compact('stores');
        return view('manage-stores')->with($data);
    }

    public function viewAddStores(){
        return view('add-new-store');
    }

    public function viewUpdateStore($id, $name){
        $store = Stores::find($id);
        $data = compact('store');
        return view('update-store')->with($data);
    }

    // Action Functions
    public function addNewStores(Request $request){
        $request->validate([
            'name' => 'required',
            'street' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required'
        ]);

        $new = new Stores();
        $new->store_name = $request['name'];
        $new->phone = $request['phone'];
        $new->street = $request['street'];
        $new->city = $request['city'];
        $new->state = $request['state'];
        $new->pincode = $request['pincode'];
        $new->country = $request['country'];
        $new->save();

        return back()->with('msg', 'New Store Inserted');
    }

    public function updateStore(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'street' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required'
        ]);

        $new = Stores::find($id);
        $new->store_name = $request['name'];
        $new->phone = $request['phone'];
        $new->street = $request['street'];
        $new->city = $request['city'];
        $new->state = $request['state'];
        $new->pincode = $request['pincode'];
        $new->country = $request['country'];
        $new->save();

        return back()->with('msg', 'Store Updated');
    }

    public function deleteStore($id){
        $new = Stores::find($id);
        $new->delete();
        return back()->with('msg', 'Store Deleted');
    }

    public function updateStoreStatus($id, $status){
        $new = Stores::find($id);
        $new->status = $status;
        $new->save();
        return back()->with('msg', 'Status Updated');
    }
}
