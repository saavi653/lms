<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    
    public function index(Request $request)
    {
        $categories=Category::visible()->active()->get();
        $levels=Level::get();
       if ($request['search'])
       {
            $courses= Course::search($request['search'])->visible()->get();    
       }
       elseif ($request['category'])
       {
            $courses= Course::filter($request['category']);
       }
       elseif ($request['level'])
       {
            $courses= Course::levelfind($request['level'])->get();
       }
       elseif ($request['order'])
       {
            $courses= Course::sort($request['order'])->visible()->get();
       }
       elseif ($request['sort'])
       {
            $courses = Course::categorygroup($request['sort'])->visible()->get();
       }
       else
       {
            $courses=Course::visible()->get();     
       }

        return view('course.index', compact('courses', 'categories', 'levels'));
    }   

    public function create()
    {
        $categories=Category::visible()->active()->get();
        $levels= Level::get();

        return view('course.create',compact('categories', 'levels'));
    }

    public function store(Request $request)
    {
        $categories=Category::visible()->active()->pluck('id')->toArray();
    
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'level_id' => 'required',
            'category_id' => ['required',
            Rule::in($categories)
            ]  
        ]);
      
        $attributes +=[

            'user_id' => Auth::user()->id,
            'status_id' => 1

        ];
        if ($request['certificate'])
        {
            $attributes+=[

                'certificate' => 1
            ];
        }
        Course::create($attributes);
        if ($request->get('save')=='Save')
        {
            return redirect()->route('courses.index')
                ->with('success', 'course created successfully');
        }

        return back()->with('success', 'course created successfully');    
    }

    public function show(Course $course)
    {

        return view('course.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories=Category::visible()->active()->get();
        $levels= Level::get();

        return view('course.edit', compact('categories', 'levels', 'course'));
    }

    public function update(Course $course, Request $request){

        $categories=Category::visible()->active()->pluck('id')->toArray();
        $attributes = $request->validate([

            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'level_id' => 'required',
            'category_id' => ['required',
                Rule::in($categories)
            ],
        ]);
      
        $attributes +=[

            'user_id' => Auth::user()->id,
            'status_id' => 1,
            
        ];

        if ($request['certificate'])
        {
            $attributes+=[
                
                'certificate' => TRUE
            ];
        }
        else
        {
            $attributes+=[
                
                'certificate' => FALSE
            ];
        }
        $course->update($attributes);

        return redirect()->route('courses.show',$course)
            ->with('success','course updated successfully'); 
    }

    public function status(Request $request, Course $course)
    {
        if ($request['status']=='publish')
        {
            $newstatus=['status_id' => Course::PUBLISH];
            $course->update($newstatus);
        }
        elseif ($request['status']=='archieve')
        {
            $newstatus=['status_id' => Course::ARCHIEVE];
            $course->update($newstatus);
        }
        else
        {
            $newstatus=['status_id' => Course::DRAFT];
            $course->update($newstatus);
        }

        return back();
    }
    
}
