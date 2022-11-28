@include('dashboard')
@include('navbar')

<div class="container6">
</div>
<div class="dropdown item3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Add 
            </button>
           
            <form action="{{ route('enrolled.store',$course) }}" method="POST">
                @csrf
            <div>
            <ul class="dropdown-menu"> 
            @foreach($users as $user) 
            <li><input type="checkbox"  name="user_id[]" value="{{ $user->id }}">
            <label>{{ $user->first_name }}</label>
            @endforeach
           <li>
            <input type="submit" name="submit" value="Add">
            </li> 
            </div>
            </form>
            <h4>enrolled users</h4>
            @foreach($enrolledUsers as $enrolledUser) 
                {{ $enrolledUser->first_name }}
                <form action="{{ route('enrolled.delete', ['course' => $course->id, 'user' => $enrolledUser->id]) }}" method="POST">
                @csrf
                @method('DELETE')
              <input type="submit" name="submit" value="unenroll" class="btn btn-danger">
            </form> 
            @endforeach
</div> 
            