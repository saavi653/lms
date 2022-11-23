@include('dashboard')
<form action="{{ route('users.store')}}" method="POST">
    @csrf
    <div class="outer3">
            <div class="bold"><label>Firstname</label></div>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="input" required>
            <div class="error">
                @error('first_name')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label>Lastname</label></div>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="input" required>
            <div class="error">
                @error('last_name')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label>Email</label></div>
            <input type="email" name="email" value="{{ old('email') }}" class="input" required>
            <div class="error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label >Phone</label></div>
                <input type="text" name="phone" value="{{ old('phone') }}" class="input" required>
                <div class="error">
                @error('phone')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label >Gender</label></div>
            <input type="radio" name="gender" value="male" >male
            <input type="radio" name="gender" value="female" >female
            <div class="error">
                @error('gender')
                {{ $message }}
                @enderror
            </div>
            <div class="bold"><label>Role</label></div>
            <select name="role_id" class="input">
                @foreach($roles as $role)
                <option value="{{ $role->id }}"> {{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
            {{ $message }}
            @enderror
            <div class="btn11">
            <input type="submit" name="submit" class="btn btn-secondary" value="INVITE USER"> 
            <input type="submit" name="submit" class="btn btn-secondary" value="INVITE USER AND INVITE ANOTHER " >
            <a href="{{ route('users.index') }}" class="btn btn-light">cancel</a></div>
    </div>
    </div>
</form>
</body>
</html>