<?php

namespace App\Http\Controllers;
use App\Models\CourseUnit;
use App\Models\Course;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function create(Course $course){

       return view('unit.create', compact('course'));
    }
    public function store(Course $course, Request $request){
       
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
        ]);

        $unit=Unit::create($attributes);
        CourseUnit::create([
            'course_id' => $course->id,
            'unit_id' => $unit->id

        ]);
       
        if ($request['Submit']=='Save')
        {
            return redirect()->route('courses.show', $course)
                ->with('success','unit created successfully');
        }

        return back()->with('success', 'unit created successfully');
     }
     public function edit(Course $course, Unit $unit )
    {
        return view('unit.edit',compact('unit','course'));
    }
    public function update(Request $request,Course $course,Unit $unit){

        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            
        ]);

        $unit->update($attributes);

        return redirect()->route('courses.show', $course)
            ->with('success','unit updated successfully');;
       
     }
     public function delete(Unit $unit)
     {
        $unit->delete();

        return back()->with('success', 'unit deleted successfully');;
     }
}
