<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    // Function to verify Email 
    public function verifyMail(Request $request)
    {
        $hash = $request['mail_hash'];
        $user = User::where('mail_hash', $hash)->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);
        if ($user > 0) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    // Function to Reset Password 
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // validating if Email is registered and must verified in order to reset password 

        $check = User::where('email', $request['email'])->count();
        if ($check == 0) {
            return response()->json(['status' => true, 'msg' => 'Invalid Email Address, Please enter your registered mail to continue']);
        } else {
            // Sending Password Reset Mail 
            Mail::to($request['email'])->send(new ForgotPassword(md5($request['email'])));
            if (Mail::failures()) {
                return response()->json(['status' => false, 'msg' => 'unable to send password reset mail please try again after some time']);
            } else {
                return response()->json(['status' => true, 'msg' => 'Please check your mail inbox to reset your password']);
            }
        }
        return response()->json(['status' => false, 'msg' => 'Something went wrong please try again']);
    }

    // Function to change Password 
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "key" => "required",
            "password" => "required",
            "confirm_password" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if($request['password'] != $request['confirm_password']){
            return response()->json(['status' => false, 'msg' => 'Confirm password are not same as password']);
        }
        
        // Changing Password 
        $user = User::where('mail_hash', $request['key'])->update(['password' => bcrypt($request['password'])]);
        // return response()->json(['status' => true, 'msg' => $user]);
        if ($user == 1) {
            return response()->json(['status' => true, 'msg' => 'Password Changed']);
        } else {
            return response()->json(['status' => false, 'msg' => 'Unable to change your password please try again after sometime or contact administrator']);
        }
    }
}
