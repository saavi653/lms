<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EmploymentController extends Controller
{
    public function index() {
        return view('learner.index', [
            'courses' => Course::whereHas('enrollments', function (Builder $query) {
                $query->where('user_id', Auth::id());
            })->get()
        ]);
    } 
    
    public function show()
    {
        return view('learner.show');
    }
}
