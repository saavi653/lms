@include('navbar')
assigned courses are :-
@if($courses->count() > 0)
@foreach($courses as $course)
    {{ $course->title }}
@endforeach
@endif