<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
   public function index(Request $request) {

    if($request['search'])
    {
        $users=User::Search($request['search']);
    }
    elseif($request['sort'])
    {
       
        $users=User::Sort()->get();
      
    }
    elseif($request['role'])
    {
        $users=User::group($request['role'])->get();
    }
    else
    {
        $users=User::all();
    }
    $roles = Role::where('slug','!=','admin')->get();  
    return view('user.index',['users'=>$users,'roles'=>$roles]);
   }

   public function create() {
    $roles = Role::where('slug','!=','admin')->get();
    return view('user.create',['roles'=>$roles]);
   }

   public function store(Request $request) {
    
       $roles = Role::where('slug','!=','admin')->get();
       $roles=$roles->pluck('id');
        $attributes= $request->validate(
            [
                'first_name'=>'required|min:3|max:255',
                'last_name'=>'required|min:3|max:255',
                'email'=>'email|required',
                'gender' => 'required',
                'phone' => 'required|numeric|min:10',
                'role_id' => ['required',
                Rule::in($roles) ]        
            ] );
                $attributes +=[
                    'created_by' => Auth::id()
                ];
            $restore=User::where('email',$request->email)->withTrashed()->first();
            if($restore!=null)
            {
                if($restore->deleted_at)
                {
                    $restore->restore();
                    return redirect()->route('user')->with('success','user restored successfully');
                }
            }
            else{
                $user = User::create($attributes);
                Notification::send($user, new SetPasswordNotification(Auth::user()));
               
                if($request->get('submit') == 'INVITE USER')
                {

                    return redirect()->route('users.index')->with('success','user created successfully');
                }
                
                return back()->with('success','user created successfully');

            }
            return back();
   }

   public function edit(User $user) {
    $roles = Role::where('slug','!=','admin')->get();

    return view('user.edit',['user'=>$user,'roles'=> $roles]);
   }

   public function update(Request $req ,User $user) {

    $data= $req->validate(
        [
            'first_name'=>'required|min:3',
            'last_name' =>'required|min:3',
            'email'=>'email',
            'phone' => 'required|integer'
        ] );
        
       $user->update($data);
       return redirect()->route('users.index')->with('success','user updated successfully');
   }

   public function delete(User $user) {
       $user->delete();
       return redirect()->route('users.index')->with('success','user deleted successfully');
   }
   public function status(User $user) {
        if($user->email_status)
        {
            $temp =['email_status'=> 0];
            $user->update($temp);   
        }
        else
        {
           $temp =['email_status'=> 1];
            $user->update($temp);    
        }
        return redirect()->route('users.index');
   }

}
