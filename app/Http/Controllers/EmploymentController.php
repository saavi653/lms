<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploymentController extends Controller
{
    public function index() {
      
    //    $course= CourseUser::get();
    //    dd($course);
    //    dd(CourseUser::where('user_id', Auth::id())->get());
      
    //     return view('employee.courses');
    }
}
