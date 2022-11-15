@include('dashboard')
<div class="outer1">
<div class="inner1">
<form action="{{ route('categories.store') }}" method="POST">
    <h2 class="heading">CREATE CATEGORY</h2>
@csrf
<label class="lbl">NAME</label>
<input type="text" name="name" style="width:60%" value="{{ old('name') }}">
<div class="error">
@error('name')
    {{ $message }}
    @enderror
</div>
<input type="submit" name="submit" class="btn btn-primary b1 b2">
</form>
</body>
</html>
</div>
</div>

