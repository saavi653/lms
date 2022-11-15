@include('layout.main')
@include('flash')
<section class="outer">
    <div class="inner">
    <h3 style="margin-left:60px;">RESET PASSWORD </h3>
    <form action="{{ route('reset-password',$user) }}" method="POST">
        @csrf
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
            <label class="lab">Password confirmatiom</label>
            <input type="password" name='password_confirmation' class="b1">
            </div>
            <div class="error">
            @error('password_confirmation')
            {{ $message }}
            @enderror
            </div>
        <input type="submit" name="submit" class="btn btn-primary b1 b2">
    </form>
</div>
</section>