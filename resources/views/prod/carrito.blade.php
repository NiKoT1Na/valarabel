@extends('layouts.app')

@section('content')

<div>
	@foreach ($content as $post)	
		{{$post->name}}
		
	@endforeach
</div>

@endsection
