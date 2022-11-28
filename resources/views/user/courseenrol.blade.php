@include('dashboard')
@include('navbar')
<div class="container6">
</div>
<div class="dropdown item3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Add 
            </button>
           
            <form action="{{ route('enrolledCourse.store',$user) }}" method="POST">
                @csrf
            <div>
            <ul class="dropdown-menu"> 
            @foreach($courses as $course) 
            <li><input type="checkbox"  name="course_id[]" value="{{ $course->id }}">
            @error('course_id')
            {{ $message }}
            @enderror 
            <label>{{ $course->title }}</label>
            @endforeach
           <li>
            <input type="submit" name="submit" value="Add">
            </li> 
            </div>
            </form>
            <h4>enrolled courses</h4>
            @foreach($enrolledCourses as $enrolledCourse) 
                {{ $enrolledCourse->title }}
                <form action="{{ route('enrolledCourse.delete', ['course'=> $enrolledCourse->id,'user' => $user])}}" method="POSt">
                @csrf
                @method('DELETE')
              <input type="submit" name="submit" value="UnAssign" class="btn btn-danger">
            </form> 
            @endforeach
</div> 
            