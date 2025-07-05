<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;

class User extends Controller
{
    // View Functions 
    function viewUser(){
        $users = ModelsUser::all();
        $data = compact('users');
        return view('users')->with($data); 
    }

    function viewManageUser($id, $name){
        $users = ModelsUser::find($id);
        $data = compact('users', 'id');
        return view('manage-user')->with($data); 
    }

    // Action Functions 
    function updateStatus($id, $stt){
        $user = ModelsUser::find($id);
        $user->status = $stt;
        $user->save();
        return redirect('/users')->with('msg', 'Status Updated');
    }
}
