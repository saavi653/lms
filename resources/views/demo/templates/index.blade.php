@include('layout.main')
@include('navbar')
<h4>listing of templates :-</h4>
@foreach($templates as $template)
<br>
{{ $template->name }}
@endforeach