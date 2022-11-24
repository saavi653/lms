@include('dashboard')
<div class="container5">
<div class="head2">
<span class="head3"><h4><a href="{{ route('courses.index') }}">Courses</a> > Edit Course</h4></span>
</div>
<div class="container1">
    <form method="POST" action="{{ route('courses.update',$course) }}">
        @csrf
    <div class="bold"><label >What Will Be The Course Name ?</label></div>
   <input type="text" name="title" placeholder="Enter Course Name" required class="input" value="{{ $course->title }}">
   @error('title')
    {{ $message }} 
    @enderror    
    <div class="bold"><label >Provider a Brief Desciption For What The Course Is About</label></div>
    <textarea name="description" class="input" required >{{ $course->description }}</textarea>
    @error('title')
    {{ $message }} 
    @enderror  
    <div class="bold">Which Category Should The Course Be In</div>
    <select class="input" name="category_id" required>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" 
        @if($category->id==$course->category_id) selected
        @endif >
        {{ $category->name }}</option> 
        @endforeach
    </select>  
    @error('category_id')
    {{ $message }} 
    @enderror  
    <div class="bold">What Is The Level of Course?</div>
    <select class="input" name="level_id" required >
        @foreach($levels as $level)
        <option value="{{ $level->id }}"  
        @if($level->id==$course->level_id) selected
        @endif >
        {{ $level->name }}</option> 
        @endforeach
    </select> 
    @error('level_id')
    {{ $message }} 
    @enderror    
   <div class="bold" >
    <input type="checkbox" name="certificate" value="certificate" @if($course->certificate) checked
    @endif >
    <label for="certificate">Certificate</label>
    <div class="bold"><input type="submit" name="Submit" value="submit" class="btn btn-secondary"></div>
    <a href="{{ route('courses.show',$course) }}" class="btn btn-light btn8">cancel</a>
</div>
    </form>
</div>
</div>
