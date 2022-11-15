@include('dashboard')
<div class="dropdown drop d6 d10">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{ Auth::user()->fullname}}
    </button>
  
    <ul class="dropdown-menu">
      <li><a class="dropdown-item " href="">Accounts & Settings</a></li>
      <li><a class="dropdown-item " href="{{ route('logout') }}">Logout</a></li>
    </ul>
  </div>
