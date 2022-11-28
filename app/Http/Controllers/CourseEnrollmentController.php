<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
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
        // $courses = Course::VisibleTo(Auth::user())
        // ->whereDoesntHave('enrollments', function(Builder $query) use($user) {
        //     $query->where('user_id',$user->id);
        // })
        // ->get();
        // $course_id = $courses->pluck('id')->toArray();
    
        $attribute = $request->validate(
        [
            'course_id' => 'required'  
        ]);

        $user->enrollments()->attach($attribute['course_id']);

        return back()->with('success','course enrolled succesfully');;
    }
    public function delete(Course $course,User $user)
    {
        $user->enrollments()->detach($course->id);
        return back()->with('success','course unenrolled succesfully');
    }
}
