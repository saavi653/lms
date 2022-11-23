@include('dashboard')
<div class="container3">
  <span class="head3">
    <h4><a href="{{ route('courses.index') }}">Courses</a> ><a href="">{{ $course->title }}</a> </h4>
  </span>
  <a href="{{ route('units.create',$course) }}" class="btn btn-primary btn7">Add Unit</a>
  <div class="conn">
    <div class="pic">
    </div>
    <div class="title1">{{ $course->title }}</a>
      <div class="des">{{ $course->description}}</div>
      <div class="edit"><a href="{{ route('courses.edit',$course) }}">EDit Course Info</a></div>
    </div>
  </div>
  @foreach($course->units as $unit)
  <div class="conn">
    <div class="title1">{{ $unit->title }}</a>
      <div class="des">{{ $unit->description}}</div>
      <div class="edit1"><a href="{{ route('units.edit',['unit'=> $unit,'course' => $course]) }}">EDit Unit Info</a></div>
      <form action="{{ route('units.delete',$unit)}}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" name="submit" value="delete" class="btn btn-danger delete">
      </form>
    </div>
  </div>
  @endforeach
</div>