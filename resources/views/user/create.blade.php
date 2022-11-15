@include('dashboard')
<div class="outer1">
<div class="inner1">
<form action="{{ route('users.store')}}" method="POST">
    @csrf
    <label class="lbl">Firstname</label>
    <input type="text" name="first_name" value="{{ old('first_name') }}">
    <div class="error">
    @error('first_name')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">Lastname</label>
    <input type="text" name="last_name" value="{{ old('last_name') }}">
    <div class="error">
    @error('last_name')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">Email</label>
    <input type="email" name="email" value="{{ old('email') }}">
    <div class="error">
    @error('email')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">Gender</label>
    <input type="radio" name="gender" value="male" >male
    <input type="radio" name="gender" value="female" >female
    <div class="error">
    @error('gender')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">Phone</label>
    <input type="text" name="phone" value="{{ old('phone') }}">
    <div class="error">
    @error('phone')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">Role</label>
    <select name="role_id" > 
    @foreach($roles as $role)
        <option value="{{ $role->id }}"> {{ $role->name }}</option>
    @endforeach
    </select>
    @error('role_id')
    {{ $message }}
    @enderror
    <input type="submit" name="submit" class="btn btn-primary b1 b2" >
</form> 
</body>
</html>
    </div>
</div>

      