@include('dashboard')
@include('navbar')

<div class="out">

    <h3>courses</h3>
    <a class="btn btn-primary btn5" href="{{ route('courses.create') }}">create new course</a>
    <div class=c1>
        <div class="iteam">All Courses
        </div>
        <div class="iteam">Published
        </div>
        <div class="iteam">Draft
        </div>
        <div class="iteam">Archieve
        </div>
    </div>
    <div class=c2>
        <form action="" method="get">
            <div class="d-flex iteam1 srh">
                <input class="form-control" type="text" name="search" placeholder="Search by Course and description ">
                <i class="bi bi-search"></i>
            </div>
        </form>
        <div class="dropdown iteam1 ">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Category
            </button>
            <ul class="dropdown-menu ">
            @foreach($categories as $category)
            <li><a class="dropdown-item " href="{{ route('courses.index') }}?category={{ $category->id }}">{{ $category->name }}</a></li>
            @endforeach
            </ul>
        </div>
        <div class="dropdown iteam1 ">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Level
            </button>
            <ul class="dropdown-menu">
            @foreach($levels as $level)
            <li><a class="dropdown-item " href="{{ route('courses.index') }}?level={{ $level->id }}">{{ $level->name }}</a></li>
            @endforeach
            </ul>
        </div>
        <div class="dropdown iteam2 ">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort by
            </button>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item " href="{{ route('courses.index') }}?order=asc">A-Z Order</a></li>
            <li><a class="dropdown-item " href="{{ route('courses.index') }}?order=desc">Z-A Order</a></li>
            <li><a class="dropdown-item " href="{{ route('courses.index')}}?order=new">Newest</a></li>
            <li><a class="dropdown-item " href="{{ route('courses.index') }}">Oldest</a></li>
            </ul>
        </div> 
    </div>
    
    @foreach($courses as $course)
    <div class="conn">
        <div class="pic"> 
        </div>
        <div class="des1 des"><a href="{{ route('courses.index') }}?sort={{ $course->category->id}}">{{ $course->category->name }}</a></div>
      <a href="{{ route('courses.show',$course) }}" ><div class="title1">{{ $course->title }}</a>
      <div class="des">Created By :{{ $course->user->fullname }}| Created On:{{ $course->created_at }}</div>
       <div class="des">{{ $course->description}}</div>
       <div class="des">{{ $course->level->name }}</div>

    </div>
    <div class="status"> {{ $course->status->name }}</div> 
        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="dots dot">
        <i class="bi bi-three-dots-vertical "></i></button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('courses.edit',$course)}}">Edit Course</a></li>
          <li><a class="dropdown-item" href="{{ route('enrolled.index',$course)}}">Users</a></li>
          @if($course->status_id!=1)
          <li><a class="dropdown-item" href="{{ route('courses.status',$course) }}?status=publish">Publish</a></li>
          @endif
          @if($course->status_id!=2)
          <li><a class="dropdown-item" href="{{ route('courses.status',$course) }}?status=archieve">Archieve</a></li>
          @endif
          @if($course->status_id!=3)
          <li><a class="dropdown-item" href="{{ route('courses.status',$course) }}?status=draft">Draft</a></li>
          @endif
        </ul>
    </div>
    @endforeach  
    
</div>
