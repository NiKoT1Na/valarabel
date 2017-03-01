@extends('layouts.app')

@section('content')

<div>
	@foreach ($reviews as $review)
		<div>
			nombre de la review
			{{$review->name}}
		</div>	
		<div>
			{{$review->details}}
		</div>
		<div>
			nombre de usuario
			{{$review->user->name}}
		</div>
		{!! Form::open(['route' => ['aproved']]) !!}
			{{Form::hidden('review_id', $review->id)}}
	   		{!! Form::submit('Aprobar') !!}
	   	{!! Form::close() !!}
		{!! Form::open(['route' => ['denied']]) !!}
			{{Form::hidden('review_id', $review->id)}}	
	   		{!! Form::submit('Borrar') !!}
	   	{!! Form::close() !!}

	@endforeach 
</div>

@endsection
