@include('dashboard')
<div class="outer1">
<div class="inner1">
<form action="{{ route('users.update',$user) }}" method="POST"> 
    @csrf
    <label class="lbl">firstname</label>
    <input type="text" name="first_name" value="{{ $user->first_name }}">
    <div class="error">
    @error('first_name')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">lastname</label>
    <input type="text" name="last_name" value="{{ $user->last_name }}">
    <div class="error">
    @error('last_name')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">phone</label> 
    <input type="text" name="phone" value="{{ $user->phone }}">
    <div class="error">
    @error('phone')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">email</label> 
    <input type="email" name="email" value="{{ $user->email }}">
    <div class="error">
    @error('email')
    {{ $message }}
    @enderror
    </div>
    <label class="lbl">gender</label> 
    <input type="text" name="gender" value="{{ $user->gender }}">
    <div class="error">
    @error('email')
    {{ $message }}
    @enderror
    </div>
    <input type ="submit" name="submit" class="btn btn-primary b1 b2">
</form>
</body>
</html>