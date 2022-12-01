<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserEnrolmentController extends Controller
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

        return view('course.userenrol', [
            'users' => $users,
            'enrolledUsers' => $course->enrollments()->get(),
            'course' => $course
        ]);
    }
    public function store(Course $course,Request $request)
    {
       
        $attribute = $request->validate([
            'user_id' => [
                'required',
                'array',
                Rule::in(User::VisibleTo(Auth::user())
                    ->whereDoesntHave('enrollments', function(Builder $query) use($course) {
                        $query->where('course_id', $course->id);
                    })
                    ->active()
                    ->employee()
                    ->get()
                    ->pluck('id')
                    ->toArray()
                )
            ]
        ]);
        $course->enrollments()->attach($attribute['user_id']);

        return back()->with('success','user enrolled succesfully');;
    }
    public function delete(Course $course,User $user)
    {
        $course->enrollments()->detach($user->id);

        return back()->with('success','user unenrolled succesfully');
    }
}