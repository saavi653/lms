@include('dashboard')
@include('navbar')
<div class="container5">
    <h4>Create Test</h4>
    @csrf
    <div class="outer2">
    <div class="container4">
    <form action="{{ route('courses.units.tests.questions.update', [$test, $question]) }}" method="POST"> 
     @csrf   
    <div class="bold"><label>WRITE A QUESTION.</label></div>
    <input type="text" name="question" class="input" value="{{ $question->question }}" required>
    @error('question')
    {{ $message }}
    @enderror
    @for($i=0;$i<=3;$i++)
    <div class="bold"><label>OPTION-{{ $i }}</label></div>
    <input type="radio" name="answer" value="{{ $i }}"><input type="text" name="option[]".$i class="input" required> 
    @error('option'.$i)
    {{ $message }}
    @enderror
    @error('answer')
    {{ $message }}
    @enderror
    @endfor
    <input type="submit" name="submit" class="btn btn-secondary" value="SAVE"> 
    <input type="submit" name="submit" class="btn btn-secondary" value="SAVE AND ADD ANOTHER " >
    </div>
    </div>  
    </div> 
</form>