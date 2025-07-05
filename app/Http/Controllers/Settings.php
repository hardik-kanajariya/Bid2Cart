<?php

namespace App\Http\Controllers;

use App\Models\InvoiceSettings;
use App\Models\Logs;
use App\Models\Settings as ModelsSettings;
use Illuminate\Http\Request;

class Settings extends Controller
{
    // View Function
    public function viewSettings(){
        $settingsData = ModelsSettings::find(1);
        $invoice = InvoiceSettings::find(1);
        $logs = Logs::orderBy('id', 'DESC')->get();
        return view('settings')->with(compact('settingsData', 'invoice', 'logs'));
    }

    // Function to update settings
    public function updateSettings($update, Request $request){
        $data = ModelsSettings::find(1);
        $msg = '';
        if($update == 'terms'){
            $data->terms = $request['update'];
            $msg = 'Terms & Conditions updated';
        }
        if($update == 'policy'){
            $data->policy = $request['update'];
            $msg = 'Privacy Policy updated';
        }
        if($update == 'about'){
            $data->about_us = $request['update'];
            $msg = 'About us updated';
        }
        if($update == 'shipping'){
            $data->shipping_info = $request['update'];
            $msg = 'Shipping info updated';
        }
        if($update == 'consignment'){
            $data->consignments = $request['update'];
            $msg = 'Consignment updated';
        }
        if($update == 'suspension'){
            $data->account_suspension = $request['update'];
            $msg = 'Account suspension Message updated';
        }
        $data->save();
        return back()->with('msg', $msg);
        // return $request->all();
    }

    // Updating Invoice Settings
    public function updateInvoiceSettings(Request $request){
        $request->validate([
            'tax' => 'required',
            'fee' => 'required'
        ]);

        $in = InvoiceSettings::find(1);
        $in->tax = $request['tax'];
        $in->b2c_fee = $request['fee'];
        $in->save();

        return back()->with('msg', 'Invoice Details are Updated');
    }
}
