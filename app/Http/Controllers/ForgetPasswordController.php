<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('forgetpassword');
    }

    public function forgetpassword(Request $request )
    {
       if($user=User::where('email',$request->email)->get())
       {
            Notification::send($user, new ForgetPasswordNotification($user));
        }
          
       return back()->with('success','email does not exist');
    }
    public function create()
    {
        return view('createpassword');
    }
    public function store(Request $request)
    {
       $user=User::where('email',$request->email)->first();
        $attributes=$request->validate([

            'email' => 'required|email|min:3|max:255',
            'password' => 'required|min:3|max:255',
            'confirmpassword' => 'same:password'
        ]);
        $user->update([
            'email' => $attributes['email'],
            'password' => $attributes['password']
        ]);

        return redirect('/');      
    }
}
