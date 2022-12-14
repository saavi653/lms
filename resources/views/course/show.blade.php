@include('dashboard')
@include('navbar')
<div class="container3">
  <span class="head3">
    <h4><a href="{{ route('courses.index') }}">Courses</a> ><a href="">{{ $course->title }}</a> </h4>
  </span>
  <a href="{{ route('courses.units.create',$course) }}" class="btn btn-primary btn7">Add Unit</a>
  <div class="conn">
    <div class="pic">
    </div>
    <div class="title1">{{ $course->title }}</a>
      <div class="des">{{ $course->description}}</div>
      <div class="btn btn-light edit"><a href="{{ route('courses.edit',$course) }}">EDit Course Info</a></div>
      <div class="bar">
        <span class="item6">Course duration
          <div>{{ $course->units()->sum('duration')  }} </div>
        </span>
        <span class="item6">Total Unit
          <div>{{ $course->units()->count() }}</div>
        </span>
        <span class="item6">Course Level</span>
        <span class="item6">Latest Update</span>
        <span class="item6">Certificate of Completion</span>
      </div>
    </div>
</div>
  <h5>Course Content</h5>
  @foreach($course->units as $unit)
  <div class="conn">
    <div class="title1">{{ $unit->title }}</a>
      <div class="des">{{ $unit->description}}</div>
        @foreach($unit->tests as $test)
        <br>
        {{ $test->name }}
        @endforeach</small>
      <div class="fles">
        <div class="btn btn-light edit1"><a href="{{ route('courses.units.edit',['unit'=> $unit,'course' => $course]) }}">EDit Unit Info</a></div>
        <form action="{{ route('courses.units.delete',$unit)}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="submit" name="submit" value="delete" class="btn btn-danger delete1">
      </div>    
        </form>
  @endforeach
  </div>
  </div>
  
</div>