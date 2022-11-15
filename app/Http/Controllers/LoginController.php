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
            'email' => 'required',
            'password' => 'required'
        ]);
      
        if($user->email_status)
        { 
            if(Auth::attempt($data)) 
            {
                if($user->is_employee) {

                return redirect()->route('employee');
                
            }

            return redirect()->route('dashboard');           
        } 
        }    
        return back()->with('success','user inactive');  
    }
}

    

