@include('navbar')
assigned courses are :-
@foreach($courses as $course)
    @foreach($course as $cour)
        {{ $cour->title }}
    @endforeach
@endforeach
@endif