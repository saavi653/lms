<div class="container5">
    <h4>Test</h4>
    @csrf
    <div class="outer2">
    <div class="container4">
    <form action="{{ route('learner.questions.store', [$test, $question] ) }}" method="POST"> 
    @csrf  
    @php 
        $i=0;
    @endphp
        <div class="bold"><label>{{ $question->question }}</label></div>
        @foreach($question->options as $option)
            <div class="bold"><label> OPTION- {{ $i }}</label></div>
            <input type="radio" name="answer" value="{{ $option->option }}">{{ $option->option }}
            @php 
                $i++;
            @endphp    
        @endforeach
        @error('answer')
            {{ $message }}
        @enderror
        <br><input type="submit" name="submit" class="btn btn-secondary" value="Submit">
    </div>
    </div>  
    </div> 
</form>