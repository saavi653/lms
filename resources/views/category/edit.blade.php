@include('dashboard')
@include('navbar')
<div class="outer1">
<div class="inner1">
<form action="{{ route('categories.update', $category) }}" method="POST">
<h2>EDIT CATEGORY</h2>
@csrf
<label class="lbl">NAME</label>
<input type="text" name="name" value="{{ $category->name }}" style="width:60%">
<div class="error">
@error('name')
    {{ $message }}
    @enderror
</div>
<input type="text" value="{{ $category->id }}" name="id" hidden >
<input type="submit" name="submit" class="btn btn-primary b1 b2">
</form>
</body>
</html>
</div>
</div>
