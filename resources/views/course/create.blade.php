@include('dashboard')
<div class="container5">
<div class="head2">
<span class="head3"><h4><a href="{{ route('courses.index') }}">Courses</a> > Add Courses</h4></span>
</div>
<div class="container1">
    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
    <div class="bold"><label >What Will Be The Course Name ?</label></div>
   <input type="text" name="title" placeholder="Enter Course Name" required class="input" value="{{ old('title')}}">
   @error('title')
    {{ $message }} 
    @enderror    
    <div class="bold"><label >Provider a Brief Desciption For What The Course Is About</label></div>
    <textarea name="description" class="input" required placeholder="description">{{ old('description')}}</textarea>
    @error('title')
    {{ $message }} 
    @enderror  
    <div class="bold">Which Category Should The Course Be In</div>
    <select class="input" name="category_id" required>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option> 
        @endforeach
    </select>   
    @error('category_id')
    {{ $message }} 
    @enderror  
    <div class="bold">What Is The Level of Course?</div>
    <select class="input" name="level_id" required>
        @foreach($levels as $level)
        <option value="{{ $level->id }}">{{ $level->name }}</option> 
        @endforeach
    </select> 
    @error('level_id')
    {{ $message }} 
    @enderror  
   <div class="bold" >
    <input type="checkbox" name="certificate">
    <label>Certificate</label>
    <div class="bold"><input type="submit" name="save" value="Save" class="btn btn-secondary">
    <input type="submit" name="save&add" value="Save & Add Another" class="btn btn-secondary">
    <a href="{{ route('courses.index') }}" class="btn btn-light btn10">cancel</a></div>
   </div>
</div>
</div>
