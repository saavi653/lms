<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SetpasswordController extends Controller
{   

    public function index(User $user) {
      
        return view('setpassword', [
            'user' => $user
        ]);
    }
    public function setpassword(Request $request , User $user){
    
       $attributes=$request->validate([
            'password'=>'required|min:4',
            'password_confirmation' =>'required|min:4|same:password',      
        ]);
        if($user->password==null){
      
            $user->update([
                'password' => Hash::make($attributes['password']),
                'email_status' => 1
            ]);
            
            $login_user=new LoginController();
            $url = $login_user->login($request);

            return redirect($url->getTargetUrl());              
        }  

        return back()->with('success','password already set');    
    }
   
}

