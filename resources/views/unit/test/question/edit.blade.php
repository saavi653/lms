@include('dashboard')
@include('navbar')
<div class="container5">
    <h4>Create Test</h4>
    @csrf
    <div class="outer2">
    <div class="container4">
    <form action="{{ route('courses.units.tests.questions.update', [$course, $unit, $test, $question]) }}" method="POST"> 
     @csrf   
    <div class="bold"><label>WRITE A QUESTION.</label></div>
    <input type="text" name="question" class="input" value="{{ $question->question }}" required>
    @error('question')
    {{ $message }}
    @enderror
    @php 
        $i=0;
    @endphp    
    @foreach($options as $option )    
    <div class="bold"><label>OPTION-{{ $i }}</label></div>
    @if($option['answer'])
        <input type="radio" name="answer" value="{{ $i }}" checked>
    @else
        <input type="radio" name="answer" value="{{ $i }}" >
    @endif 
    <input type="text" value="{{ $option['option'] }}" name="options[]".$i class="input" required> 
    @error('option'.$i)
    {{ $message }}
    @enderror
   {{-- @error('answer')
    {{ $message }}
    @enderror --}}
    @php
    $i++ ;
    @endphp
    @endforeach
    <input type="submit" name="submit" class="btn btn-secondary" value="SAVE"> 
    <input type="submit" name="submit" class="btn btn-secondary" value="SAVE AND ADD ANOTHER " >
    </div>
    </div>  
    </div> 
</form>