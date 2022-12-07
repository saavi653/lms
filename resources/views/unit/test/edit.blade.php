@include('dashboard')
@include('navbar')
<div class="container5">
<h3> Edit Test</h3>
<form action="{{ route('courses.units.tests.update', [ 'course' => $course, 'unit' => $unit, 'test' => $test ]) }}" method="POST">
    @csrf
    <div class="outer2">
    <a class="btn btn-secondary" href="{{ route('courses.units.tests.questions.create', [ 'course' => $course, 'unit' => $unit, 'test' => $test ]) }}">Add Questions</a>
    <div class="container4">
    <div class="bold"><label>NAME</label></div>
    <input type="text" name="name" required class="input" value="{{ $test->name }}">
    <div class="bold"><label>DURATION</label></div>
    <input type="text" name="duration" value="{{ $test->duration }}"  class="input" required>
    @error('duration')
    {{ $message }}
    @enderror
    <div class="bold"><label>PASS SCORE</label></div>
    <input type="text" name="passing_score" value="{{ $test->passing_score}}" class="input" required>
    @error('passing_score')
    {{ $message }}
    @enderror
    <input type="submit" name="Submit" class="btn btn-secondary btn6">
    <a href="{{ route('courses.units.edit',['course' => $course, 'unit' => $unit ]) }}" class="btn btn-light btn14" >cancel</a>
    </div>  
    </div> 
</form>
<h4>questions :- </h4>
@foreach($questions as $question)
<br>
{{ $question->question }}
<a href="{{ route('courses.units.tests.questions.edit', [$test, $question]) }}">EDIT</a>
<a href="{{ route('courses.units.tests.questions.delete', [$test, $question]) }}">DELETE</a>
@endforeach
</div>
