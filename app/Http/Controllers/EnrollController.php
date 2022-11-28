<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EnrollController extends Controller
{
    public function index(Course $course)
    {
        $users = User::active()
            ->employee()
            ->visibleTo(Auth::user())
            ->whereDoesntHave('enrollments', function(Builder $query) use($course) {
                $query->where('course_id', $course->id);
            })
            ->get();

        return view('employee.index', [
            'users' => $users,
            'enrolledUsers' => $course->enrollments()->get(),
            'course' => $course
        ]);
    }
    public function store(Course $course,Request $request)
    {
        $user_id = $request->validate([

        'user_id' => 'required' 
        ]);
        $course->enrollments()->attach($user_id['user_id']);

        return back()->with('success','user enrolled succesfully');;
    }
    public function delete(Course $course,User $user)
    {
        $course->enrollments()->detach($user->id);

        return back()->with('success','user unenrolled succesfully');
    }
}