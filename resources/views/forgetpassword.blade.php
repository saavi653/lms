@include('layout.main')
@include('flash')
<section class="outer">
    <div class="inner">
    <h3 style="margin-left:60px;">FORGET PASSWORD </h3>
    <form action="{{ route('mail-sending') }}" method="POST">
        @csrf
        <div class="label">
            <label class="lab">Please Enter Your Email</label>
            <input type="text" name="email" class="b1">
            </div>
            <div class="error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <input type="submit" name="submit" class="btn btn-primary b1 b2">
    </form>
</div>
</section>