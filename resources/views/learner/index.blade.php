@include('navbar')
@include('flash')
assigned courses are :-
@if($courses->count() > 0)
    @foreach($courses as $course)
    {{-- @dd($course->units) --}}
        <a href="{{ route('learner.units',$course) }}">{{ $course->title }}</a>
    @endforeach
@else
    {{ __('No record found') }}
@endif
