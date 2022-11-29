<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploymentController extends Controller
{
    public function index() {
      
       $course_ids = CourseUser::where('user_id', Auth::id())->get()->pluck('course_id');
      
       if($course_ids!=null)
       {
            foreach($course_ids as $course_id) {

                $courses[]=Course::where('id',$course_id)->get();
            }
            return view('learner.index',['courses' => $courses]);
       }
       
       return view('learner.index');   
    }
    public function show()
    {
        return view('learner.show');
    }
}
