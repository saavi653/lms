@include('layout.main')
@include('flash')
<section class="outer">
    <div class="inner">
    <h3 style="margin-left:60px;">CREATE NEW PASSWORD </h3>
    <form action="{{ route('password.store') }}" method="POST">
        @csrf
        <div class="label">
            <label class="lab">Email</label>
            <input type="text" name="email" class="b1">
            </div>
            <div class="error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="label">
            <label class="lab">Password</label>
            <input type="password" name="password" class="b1">
            </div>
            <div class="error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <div class="label">
            <label class="lab">ConfirmPassword</label>
            <input type="password" name="confirmpassword" class="b1">
            </div>
            <div class="error">
            @error('confirmpassword')
            {{ $message }}
            @enderror
            </div>  
        <input type="submit" name="submit" class="btn btn-primary b1 b2">
    </form>
</div>
</section>