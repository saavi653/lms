<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Unit;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create(Course $course,Unit $unit)
    {
        return view('unit.test.create', [
            'course' => $course, 
            'unit' => $unit
        ]);
    }
    public function store(Course $course, Unit $unit, Request $request)
    {  
        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'duration' => 'required|between:1,100',
            'passing_score' => 'required|min:1|max:255'
        ]);
        $attributes += [
            'unit_id' => $unit->id
        ];
        $test = Test::create($attributes);

        $test->lessons()->create([

            'unit_id' => $unit->id,
            'duration' => $test->duration

        ]);

        $duration=Lesson::where('unit_id',$unit->id)->sum('duration');
        $unit->where('id',$unit->id)->update(
            [
                'duration' => $duration 
            ]);
      
        return redirect()->route('courses.units.tests.edit', [$course, $unit, $test])
            ->with('success', 'test created successfully');
    
    }
    public function edit(Course $course, Unit $unit, Test $test)
    {
        $ques_ids = TestQuestion::where('test_id',$test->id)->get('question_id');
        $questions = Question::find($ques_ids);

        return view('unit.test.edit',compact('course', 'unit', 'test','questions'));
    }
    public function update(Course $course, Unit $unit, Test $test,Request $request)
    {
        $attributes = $request->validate([

            'name' => 'required|min:3|max:255',
            'duration' => 'required|between:1,100',
            'passing_score' => 'required|min:1|max:255'       
        ]);

        $test->update($attributes);

        return redirect()->route('courses.units.edit',['course' => $course, 'unit' => $unit ])
            ->with('success','unit updated successfully');

    }
    public function delete(Test $test)
    {
        $test->delete();

        return back()->with('success', 'unit deleted successfully');;
    }
}
