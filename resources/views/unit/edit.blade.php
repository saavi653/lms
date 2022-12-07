@include('dashboard')
@include('navbar')
<div class="container5">
<form action="{{ route('courses.units.update',['unit' => $unit ,'course' => $course]) }}" method="POST">
    @csrf
    <div class="outer2">
    <span class="head3"><h4><a href="{{ route('courses.index') }}">Courses </a> ><a href="{{ route('courses.show',$course) }}">{{ $course->title }}</a> > Edit Unit</h4></span>
    <a href="{{ route('courses.units.tests.create',['course' => $course ,'unit' => $unit]) }}" class="btn btn-secondary" > Add Test</a>
    <div class="container4">
    <div class="bold"><label>Title *</label></div>
    <input type="text" name="title" placeholder="enter unit name" required class="input" value="{{ $unit->title }}">
    <div class="bold"><label>Description *</label></div>
    <textarea name="description" required class="input">{{ $unit->description}}</textarea>
    <input type="submit" name="Submit" class="btn btn-secondary btn6">
    <a href="{{ route('courses.show',$course) }}" class="btn btn-light btn6">cancel</a>
    </div>  
    </div> 

</form>
{{--lesson index--}}
<h4>Lessons</h4>
@foreach($tests as $test)
<div class="fles">
{{ $test->name }}
<a  href="{{ route('courses.units.tests.edit',['course' => $course, 'unit' => $unit, 'test' => $test]) }} " class="btn btn-secondary btn12">edit </a>
<form action="{{ route('courses.units.tests.delete', $test) }}" method="POST">
    @csrf 
    @method('DELETE')
    <input type="submit" name="delete" value="delete" class="btn btn-secondary btn12"/>
</form>
</div>
@endforeach
</div>
