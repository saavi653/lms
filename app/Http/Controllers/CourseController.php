<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    
    public function index(Request $request)
    {
        $categories=Category::get();
        $levels=Level::get();
       if($request['search'])
       {
            $courses= Course::search($request['search']);    
       }
       elseif($request['category'])
       {
            $courses= Course::filter($request['category']);
       }
       elseif($request['level'])
       {
            $courses= Course::levelfind($request['level']);
       }
       elseif($request['order'])
       {
            $courses= Course::sort($request['order']);
       }
       elseif($request['sort'])
       {
            $courses = Course::categorygroup($request['sort']);
       }
       else
       {
            $courses=Course::get();
       }

        return view('course.index',compact('courses','categories','levels'));
    }    
    public function create(){
        $categories = Category::get();
        $levels= Level::get();

        return view('course.create',compact('categories','levels'));
    }
    public function store(Request $request){

        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'category_id' => 'required',
            'level_id' => 'required',

        ]);
      
        $attributes +=[

            'user_id' => Auth::user()->id,
            'status_id' => 1

        ];
        if($request['certificate'])
        {
            $attributes+=[

                'certificate' => 1
            ];
        }
        Course::create($attributes);
        if($request->get('save')=='Save')
        {
            
            return redirect()->route('courses.index')->with('success','course created successfully');
        }

        return back()->with('success','course created successfully');    
    }

    public function show(Course $course)
    {
    
        return view('course.show',compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::get();
        $levels= Level::get();

        return view('course.edit',compact('categories','levels','course'));
       
    }

    public function update(Course $course,Request $request){
      
        $attributes = $request->validate([

            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'category_id' => 'required',
            'level_id' => 'required',
            
        ]);
      
        $attributes +=[

            'user_id' => Auth::user()->id,
            'status_id' => 1,
            
        ];

        if($request['certificate'])
        {
            $attributes+=[
                
                'certificate' => 1
            ];
        }
        else
        {
            $attributes+=[
                
                'certificate' => 0
            ];
        }
        $course->update($attributes);

            return redirect()->route('courses.show',$course)->with('success','course updated successfully');
        
        
    }

    public function status(Request $request,Course $course)
    {
        if($request['status']=='publish')
        {
            $newstatus=['status_id' => 1];
            $course->update($newstatus);
        }
        elseif($request['status']=='archieve')
        {
            $newstatus=['status_id' => 2];
            $course->update($newstatus);
        }
        else
        {
            $newstatus=['status_id' => 3];
            $course->update($newstatus);
        }

        return back();
    }
    
}
