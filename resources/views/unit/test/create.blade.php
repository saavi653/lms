@include('dashboard')
@include('navbar')
<div class="container5">
    <h4>Create Test</h4>
<form action="{{ route('courses.units.tests.store' ,['unit' => $unit, 'course' => $course]) }}" method="POST">
    @csrf
    <div class="outer2">
    <div class="container4">
    <div class="bold"><label>NAME</label></div>
    <input type="text" name="name" placeholder="enter test name"  class="input" required>
    @error('name')
    {{ $message }}
    @enderror
    <div class="bold"><label>DURATION</label></div>
    <input type="text" name="duration" placeholder="enter duration of test(between 1-100 minutes)"  class="input" required>
    @error('duration')
    {{ $message }}
    @enderror
    <div class="bold"><label>PASS SCORE</label></div>
    <input type="text" name="passing_score" placeholder="enter passing score"  class="input" required>
    @error('passing_score')
    {{ $message }}
    @enderror
    <input type="submit" name="Submit" value="Save" class="btn btn-secondary btn6">
<a href="{{ route('courses.units.edit',['course' => $course, 'unit' => $unit ]) }}" class="btn btn-light" >cancel</a>
    </div>
    </div>  
    </div> 
</form>