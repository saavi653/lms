@include('dashboard')
@include('navbar')
<form action="{{ route('users.update',$user) }}" method="POST">
    @csrf
    <div class="outer3">
            <div class="bold"><label>Firstname</label></div>
            <input type="text" name="first_name" value="{{ $user->first_name }}" class="input" required>
            <div class="error">
                @error('first_name')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label>Lastname</label></div>
            <input type="text" name="last_name" value="{{ $user->last_name }}" class="input" required>
            <div class="error">
                @error('last_name')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label>Email</label></div>
            <input type="email" name="email" value="{{ $user->email }}" class="input" required>
            <div class="error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label >Phone</label></div>
                <input type="text" name="phone" value="{{ $user->phone }}" class="input" required>
                <div class="error">
                @error('phone')
                {{ $message }}
                @enderror
            </div>
            @if(Auth::user()->isadmin)
            <div class="bold"><label>Role</label></div>
            <select name="role_id" class="input">
                @foreach($roles as $role)
                <option value="{{ $role->id }}"> {{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
            {{ $message }}
            @enderror
            @endif
            <div class="btn9">
            <input type="submit" name="submit" class="btn btn-secondary" value="Update Profile">
            <a href="{{ route('users.index') }}" class="btn btn-light">cancel</a></div>
    </div>
    </div>
</form>
</body>
</html>
