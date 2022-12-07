<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Unit;
use Attribute;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class QuestionController extends Controller
{
    public function create(Course $course,Unit $unit, Test $test)
    {
        return view('unit.test.question.create', compact('course', 'unit', 'test'));
    }
    public function store(Course $course, Unit $unit, Test $test, Request $request)
    {
    
        $attributes=$request->validate([

            'question' => 'required|max:255|min:3',
            'answer' => [
                'required',
                // Rule::in(0,1,2,3)
            ],   
            'option' =>  [
                'required','array ',
                // Rule::in(0,1,2,3)
            ]
        ]);
        $ans_key=$attributes['answer'];
        $ans=$attributes['option'][$ans_key];

        $question = Question::create([
            'question' => $attributes['question']
        ]);

        Option::create([
            'question_id' => $question->id,
            'answer' => $ans,   
            'option' => implode(',',$attributes['option'])
        ]);
       
        TestQuestion::create([
            'test_id' => $test->id,
            'question_id' => $question->id
        ]);
        if($request->submit=="SAVE")
        {
            return redirect()->route('courses.units.tests.edit',
                [
                    'course' => $course,
                    'unit' => $unit,
                    'test' => $test,
                ])
                ->with('success', 'question created successfully');
        }
        
        return back()->with('success', 'question created successfully');
    }

    public function edit(Course $course, Unit $unit, Test $test, Question $question)
    {
        $data=Option::where('question_id', $question->id)->first();
        $answer=$data->answer;
        $options=explode(',', $data->option);

        return view('unit.test.question.edit', compact('course', 'unit', 'test', 'question', 'options', 'answer'));
    }
    public function update(Course $course, Unit $unit, Test $test, Question $question, Request $request)
    {
        $attributes=$request->validate([

            'question' => 'required|max:255|min:3',
            'answer' => [
                'required',
                // Rule::in(0,1,2,3)
            ],    
            'option' =>  [
                'required', 'array ',
                // Rule::in(0,1,2,3)
            ]
        ]);
        $ans_key=$attributes['answer'];
        $ans=$attributes['option'][$ans_key];

        Question::where('id', $question->id)->update([

            'question' => $attributes['question']  
        ]);  
        
        Option::where('question_id',$question->id)->update([
            'answer' => $ans,   
            'option' => implode(',',$attributes['option'])
        ]);   
    
        if($request->submit=="SAVE")
        {
            return redirect()->route('courses.units.tests.edit',
                [
                    'course' => $course,
                    'unit' => $unit,
                    'test' => $test,
                ])
                ->with('success', 'question updated successfully');
        }
        
        return back()->with('success', 'question updated successfully');
    }
    public function delete(Question $question)
    {
        $question->delete();

        return back()->with('success','question deleted successfully');
    }
}
