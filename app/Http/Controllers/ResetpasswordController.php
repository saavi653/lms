<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResetpasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ResetpasswordController extends Controller
{
    public function index(User $user) {

        return view('resetpassword', [
            'user' => $user
        ]);
       
    }

    public function resetpassword(User $user, Request $request){
      
       $attributes= $request->validate([
            'password' => 'required|min:5',
            'password_confirmation' =>'required|min:5|same:password'
        ]);
        $user->update([
            'password' => Hash::make($attributes['password'])
        ]);
        Notification::send($user, new ResetpasswordNotification(Auth::user(),$attributes['password']));
        
        return redirect()->route('users.index');
    }
}
