@include('dashboard')
<div class="top">
  <h3 class="head1">Categories</h3>
<form action="" method="get">
            <div class="d-flex search">
                <input class="form-control" type="text" name="search" placeholder="Search by Name and Email" value="{{ request()->search }}">
                <i class="bi bi-search"></i>
            </div>
        </form>
  <div class="dropdown drop d6">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    {{Auth::user()->fullname }}
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item " href="">Accounts & Settings</a></li>
      <li><a class="dropdown-item " href="{{ route('logout') }}">Logout</a></li>
    </ul>
  </div>
  <a class="btn btn-primary btn4" href="{{ route('categories.create')}}">Create Category</a>
  <div class="dropdown drop d7">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      latest created date 
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item " href="{{ route('categories.index') }}?sort=new">Newest</a></li>
      <li><a class="dropdown-item " href="{{ route('categories.index') }}">Oldest</a></li>
      <li><a class="dropdown-item " href="{{ route('categories.index') }}?sort=asc">A-Z</a></li>
      <li><a class="dropdown-item " href="{{ route('categories.index') }}?sort=desc">Z-A</a></li>
    </ul>
  </div>
  
</div>
<table class="table table-striped details-table" id="table1">
  <tr>
    <th>
      NAME
    </th>
    <th>
      CREATED BY
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
  
  @foreach($categories as $category)
  <tr>
    <td>{{ $category->name }}</td>

    <td>{{ $category->user->fullname}}
      <span class="eml">{{ $category->user->email }}</span>
    </td>
    <td>{{ $category->courses_count }}</td>
    <td>{{ $category->created_at }}</td>
    <td>
      @if($category->status)
      <p class="active">ACTIVE</p>
      @else
      <P class="inactive">INACTIVE</P>
      @endif
    </td>
    <td >
      <div class="btn-group">
        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="dots">
          <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}">edit</a></li>
          <li>
            <form action="{{ route('categories.delete', $category) }}" method="post">
              @method('DELETE')
              @csrf
              <input type="submit" name="submit" value="delete" style="border:none;background-color:white;">
            </form>
          </li>
          @if($category->status)
          <li>
            <a class="black" href="{{ route('categories.status',$category) }}">inactive</a>
          </li>
          @else
          <li>
            <a class="black" href="{{ route('categories.status',$category) }}">active</a>
          </li>
          @endif
        </ul>
    </td>
  </tr>
  @endforeach
  {{ $categories->links() }}
</table>
<div class="page">
</div>
  </body>
  </html>