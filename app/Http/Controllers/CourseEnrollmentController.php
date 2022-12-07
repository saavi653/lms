<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Notifications\CourseEnrollNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseEnrollmentController extends Controller
{
    public function index(User $user)
    {
        $courses = Course::VisibleTo(Auth::user())
        ->whereDoesntHave('enrollments', function(Builder $query) use($user) {
            $query->where('user_id',$user->id);
        })
        ->get();
    
        return view('user.courseenrol', [
            'courses' => $courses,
            'enrolledCourses' => $user->enrollments()->get(),
            'user' => $user
        ]);
    }
    public function store(User $user,Request $request )
    {    
      //1 user-> multiple course
        $attribute = $request->validate([
            'course_ids' => [
                'required',
                'array',
                Rule::in(Course::VisibleTo(Auth::user())
                    ->whereDoesntHave('enrollments', function(Builder $query) use($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->get()
                    ->pluck('id')
                    ->toArray()
                )
            ]
        ]);
        $user->enrollments()->attach($attribute['course_ids']);
        
        $courses = Course::find($attribute['course_ids']);
       
        $courses->each(function ($course) use($user) {
            Notification::send($user, new CourseEnrollNotification($course , Auth::user()));
        });

        return back()->with('success','course enrolled succesfully');;
    }
    public function delete(Course $course,User $user)
    {
        $user->enrollments()->detach($course->id);
        return back()->with('success','course unenrolled succesfully');
    }
}
