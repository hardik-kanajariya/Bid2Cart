<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerify;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Authentication extends Controller
{
    // Admin Login view
    public function viewAdminLogin(Request $request)
    {
        return view('login');
    }

    // Authorize admin login view
    public function adminLogin(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);

        // $count = User::where('username', $request['username'], 'AND')->where('password', $request['password'])->count();
        $count = Admin::where('username', 'admin', 'AND')->where('password', 'admin')->count();
        // return $count;
        if ($count == 1) {
            session()->put('adminAuth', true);
            return redirect('/');
        } else {
            return back()->with('msg', 'Oops!, wrong credentials, Please try again');
        }
    }

    // Admin Logout
    public function adminLogout()
    {
        if (session()->has('adminAuth')) {
            session()->forget('adminAuth');
            session()->flush();
            return redirect('/login');
        } else {
            return back(); 
        }
    }


    // Register new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => "required|nullable",
            "lastname" => "required|nullable",
            "hereabout" => "nullable|nullable",
            "street" => "required|nullable",
            "city" => "required|nullable",
            "state" => "required|nullable",
            "country" => "required|nullable",
            "zipcode" => "required|nullable",
            "phone" => "required|unique:users",
            "username" => "required|unique:users|regex:/^\S*$/u",
            "email" => "required|email:rfc,dns|unique:users",
            "password" => "required|nullable",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // checking if users data is unique or not
        $uCheck = User::where('phone',$request['phone'])->orWhere('email',$request['email'])->orWhere('username',$request['username'])->count();
        if ($uCheck > 0) {
            return response()->json(['error' => 'Provided details are already registered!, Kindly please login :)']);
        }

        // Inserting Data into Database
        try {
            $user = new User();
            $user->first_name = $request['firstname'];
            $user->last_name = $request['lastname'];
            $user->address = $request['street'];
            $user->city = $request['city'];
            $user->state = $request['state'];
            $user->country = $request['country'];
            $user->zip = $request['zipcode'];
            $user->phone = $request['phone'];
            $user->ads = $request['hereabout'] ? $request['hereabout'] : '';
            $user->avatar = 'https://cdn.pixabay.com/photo/2015/03/04/22/35/avatar-659651_960_720.png';
            $user->username = $request['username'];
            $user->email = $request['email'];
            $user->mail_hash = md5($request['email']);
            $user->password = bcrypt($request['password']);
            $user->save();
            Mail::to($request['email'])->send(new EmailVerify($request['username'], $request['email']));
            return response()->json(['status' => 'true']);
        } catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    // Login and Get Login Token
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['message' => 'Invalid credentials', 'status' => false]);
        }

        $status = DB::table('users')->where('email', $request['email'])->get();
        if ($status[0]->status == 'active') {
            $token = auth()->user()->createToken('API Token')->accessToken;
            // return response(['user' => auth()->user(), 'token' => $token, 'status' => false]);
            return response(['token' => $token, 'username' => $status[0]->username, 'status' => true]);
        } elseif ($status[0]->status == 'declined') {
            return response(['message' => 'Sorry you are suspended!!! Contact owner for more details', 'status' => false]);
        } else {
            return response(['message' => 'Your Account is under review', 'status' => false]);
        }
    }

    // testing
    public function index(Request $request)
    {
        // $request->user()->sendEmailVerificationNotification();
        return "Authorization successfully";
    }
}
