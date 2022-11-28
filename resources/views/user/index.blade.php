@include('dashboard')
<div class="top">
  <h3 class="head1">Users</h3>
  <form action="" method="get">
    <div class="d-flex search">
      <input class="form-control" type="text" name="search" placeholder="Search by Name and Email" value="" >
      <i class="bi bi-search"></i>
    </div>
  </form>
  <div class="dropdown drop d6">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{ Auth::user()->fullname }}
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item " href="">Accounts & Settings</a></li>
      <li><a class="dropdown-item " href="{{ route('logout') }}">Logout</a></li>
    </ul>
  </div>
<a class="btn btn-primary btn4" href="{{ route('users.create') }}">create user</a>
<div class="dropdown drop d9">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      latest created date 
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item " href="{{ route('users.index')}}?sort=new">Newest</a></li>
      <li><a class="dropdown-item " href="{{ route('users.index') }}">Oldest</a></li>
      <li><a class="dropdown-item " href="{{ route('users.index')}}?sort=asc">A-Z</a></li>
      <li><a class="dropdown-item " href="{{ route('users.index')}}?sort=desc">Z-A</a></li>      
    </ul>
  </div>
<div class="dropdown drop d8">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      All User Type
    </button>
    <ul class="dropdown-menu">
      @foreach($roles as $role)
        <li><a class="dropdown-item " href="{{ route('users.index') }}?role={{ $role->id }}" >{{ $role->name }}</a></li>
      @endforeach
    </ul>
   
  </div>
</div>
<table class="table table-striped details-table" id="table1">
  <tr>
    <th>
      USER NAME
    </th>
    <th>
      TYPE OF USER
    </th>
    <th>
      COURSES
    </th>
    <th>
      CREATED DATE
    </th>
    <th>
      STATUS
    </th>
    <th>
    </th>
  </tr>
  @foreach($users as $user)
  @if($user->is_admin)
    @continue
  @endif
  <tr>
    <td> {{ $user->fullname}}
      <span class='eml'> {{$user->email}}</span>
    </td>
    <td>{{ $user->role->name }}</td>
    <td> </td>
    <td>{{ $user->created_at }}</td>
    @if($user->email_status)
    <td>
      <p class="active">ACTIVE </p>
    </td>
    @else
    <td>
      <p class="inactive"> INACTIVE </p>
    </td>
    @endif
    <td>
      <div class="btn-group dots">
        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="dots">
          <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('users.edit',$user) }}">edit</a></li>
          <li><a class="dropdown-item" href="{{ route('enrolledCourse.index',$user) }}">courses</a></li>
            <form action="{{ route('users.delete',$user) }}" method="post">
              @method('DELETE')
              @csrf
              <input type="submit" name="submit" value="delete" style="border:none;background-color:white;">
            </form>
          </li>
          @if($user->email_status)
          <li>
            <a class="black" href="{{ route('users.status',$user) }}"> inactive</a>
          </li>
          @else
          <li>
            <a class="black" href="{{ route('users.status',$user) }}"> active</a>
          </li>
          @endif
          <li>
            <a class="black" href="{{ route('resetpassword.index', $user) }}">reset-password</a>
          </li>
        </ul>
    </td>
  </tr>
  @endforeach
</table>
</body>

</html>
