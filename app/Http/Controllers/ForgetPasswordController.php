<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('forgetpassword');
    }

    public function forgetpassword(Request $request )
    {
        $user = User::where('email',$request->email)->first();
       if($user)
       {
           Notification::send($user, new ForgetPasswordNotification());
            return back()->with('success','mail sent');
       }
       return back()->with('success','email does not exist');
    }
    public function create(User $user)
    {
       
        return view('createpassword',['user' => $user]);
    }
    public function store(User $user, Request $request)
    {
        $attributes=$request->validate([
            'password' => 'required|min:3|max:255',
            'confirmpassword' => 'same:password'
        ]);
        $user->update([

            'password' => Hash::make($attributes['password'])
            
        ]);

        return redirect('/')->with('success', 'password changed succefully' );      
    }
}
