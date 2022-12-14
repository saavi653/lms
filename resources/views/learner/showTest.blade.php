<h4>tests</h4>
@foreach($tests as $test)
<br><a href="{{ route('learner.questions',$test) }}">{{ $test->name }}</a>
@endforeach