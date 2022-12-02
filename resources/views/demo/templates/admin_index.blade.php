@include('layout.main')
@include('navbar')
<h4>listing of templates :-</h4>
@foreach($templates as $template)
<br>
{{ $template->name }}
<a href="{{ route('template.edit',$template) }}">Edit</a>
<form action="{{ route('template.delete',$template) }}" method ="POST">
@method('delete')
@csrf 
<input type="submit" name="delete" value="delete">
</form>
<a href="{{ route('templates.push',$template) }}">PUSH</a>
@endforeach
<br><b><a href="{{ route('overview.index') }}"> GO BACK </a></b>