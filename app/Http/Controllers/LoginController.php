<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    public function login(Request $request)
    {
       $user=User::where('email',$request->email)->first();
        $data=$request->validate([

            'email' => 'required|email|min:3|max:255',
            'password' => 'required|min:3|max:255'
            
        ]);
      
        if($user->email_status)
        { 
            if(Auth::attempt($data)) 
            {       
                return redirect('/');
            }
            return back()->with('success','incorrect credential'); 
        }    
        return back()->with('success','user inactive');  
    }
}

    

