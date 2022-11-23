@include('dashboard')
<div class="container5">
<form action="{{ route('units.update',['unit' => $unit ,'course' => $course]) }}" method="POST">
    @csrf
    <div class="outer2">
    <span class="head3"><h4><a href="{{ route('courses.index') }}">Courses </a> ><a href="{{ route('courses.show',$course) }}">{{ $course->title }}</a> > Edit Unit</h4></span>
    <div class="container4">
    <div class="bold"><label>Title *</label></div>
    <input type="text" name="title" placeholder="enter unit name" required class="input" value="{{ $unit->title }}">
    <div class="bold"><label>Description *</label></div>
    <textarea name="description" required class="input">{{ $unit->description}}</textarea>
    <input type="submit" name="Submit" class="btn btn-secondary btn6">
    <a href="{{ route('courses.show',$course) }}" class="btn btn-light btn6">cancel</a>
    </div>  
    </div> 
</div>
</form>
