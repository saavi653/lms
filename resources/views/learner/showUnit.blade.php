<h4>units</h4>
@foreach($units as $unit)
<a href="{{ route('learner.tests',$unit) }}">{{ $unit->title }}</a>
@endforeach