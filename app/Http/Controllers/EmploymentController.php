<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\CourseUser;
use App\Models\Option;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestSession;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

//  WIP  
class EmploymentController extends Controller
{
    public function index() 
    {
        $courses = Course::whereHas('enrollments', function (Builder $query) {
            $query->where('user_id', Auth::id());
        })->get();
 
        return view('learner.index', [ 
            'courses' => $courses
        ]);
    } 
    
    public function showUnit(Course $course)
    {
        foreach($course->units as $unit)
        {
            // dd($course->units);
            $units = $unit->get();
        }

        return view('learner.showUnit',['units' => $units]);
    }
    public function showTest(Unit $unit)
    {
        foreach($unit->tests as $test)
        {
            $tests= $test->get();
        }
        return view('learner.showTest', ['tests' => $tests]);
    }

    public function showQuestion(Test $test)
    {
        $question_ids = TestQuestion::where('test_id', $test->id)->get('question_id');
        $question =Question::find($question_ids)->first();

        return view('learner.showQuestion',['question' => $question, 'test' => $test]);
    }

    public function store(Request $request, Test $test, Question $question)
    {
        $attributes=$request->validate([

            'answer' => [
                'required'
            ]
        ]);
        $correct_answer=Option::where('question_id', $question->id)
            ->where('answer', true)->first();
          
        $attempt=TestSession::where('user_id',Auth::id())
            ->where('test_id', $test->id)
            ->where('question_id', $question->id)->first();

        if($attempt==null)
        {
            if($correct_answer->option==$attributes['answer'])
            {
                TestSession::create([
                    'user_id' => Auth::id(),
                    'test_id' => $test->id,
                    'question_id' => $question->id,
                    'answer' => true
                ]);
            }  
            else
            {
                TestSession::create([
                    'user_id' => Auth::id(),
                    'test_id' => $test->id,
                    'question_id' => $question->id,
                    'answer' => false
                ]);
            } 

            $question_id = TestQuestion::where('test_id',$test->id)
            ->where('question_id', '>', $question->id)->first();
        
            if($question_id)
            {
                $question = Question::where('id',$question_id->question_id)->first();
                return view('learner.showQuestion', [
                    'question' => $question, 'test' => $test
                ]);
            }

            //pass or fail
            // $passing_percentage=Test::where('id', $test->id)->get('passing_score');

            // $total_questions=TestQuestion::where('test_id', $test->id)->count();

            // $passing_score = $total_questions * $passing_percentage /100;

            // $ans_count=TestSession::where('user_id', Auth::id())
            // ->where('test_id', $test->id)
            // ->where('answer', true)->count();
            
            return redirect()->route('learner.index')->with('success', 'test submitted successfully');
        }

        return redirect()->route('learner.index')->with('success', 'cant attempt the same question again');         
    }
}


