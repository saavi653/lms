<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
            'option' => 'required',
            'answer' => [
                'required',
                Rule::in([0,1,2,3])
            ],   
        ]);
        $ans_key=$attributes['answer'];
        $ans=$attributes['option'][$ans_key];

        $question = Question::create([
            'question' => $attributes['question']
        ]);
       
        TestQuestion::create([
            'test_id' => $test->id,
            'question_id' => $question->id
        ]);

        foreach($attributes['option'] as $option)
        {
            $option=Option::create([
                'question_id' => $question->id,
                'option' => $option
            ]);
        }
        Option::where('question_id',$question->id)
            ->where('option',$ans)
            ->update(['answer' => true]);

      

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
        $options = Option::where('question_id', $question->id)
            ->get()->toArray();
      
        return view('unit.test.question.edit', compact('course', 'unit', 'test', 'question', 'options'));
    }

    public function update(Course $course, Unit $unit, Test $test, Question $question, Request $request)
    {
        
        $attributes=$request->validate([

            'question' => 'required|max:255|min:3',
            'options' => 'required',
            'answer' => [
                'required',
                Rule::in([0,1,2,3])
            ]
        ]);
        $ans_key=$attributes['answer'];
        $ans=$attributes['options'][$ans_key];

        Question::where('id', $question->id)->update([

            'question' => $attributes['question']  
        ]);  
        $i=0;
    
        $question->options()->each(function($option) use($request, &$i){
           $option->update([
                'option' => $request['options'][$i]
           ]);
           $i++;
        });

        $option=Option::where('question_id',$question->id)
                ->update(['answer' => false]);
                
         Option::where('option',$ans)
            ->update(['answer' => true]); 

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
