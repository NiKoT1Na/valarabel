@extends('layouts.app')

@section('content')


@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
@endif
<div class="title">
	<div class="name titulo-bonito">
		{{$post->name}}
	</div>
</div>
<div id="oneprod">
	@if ($rating)
		<div class="score">
			Puntuacíon
			{{$rating}}
			<img src="{{URL::asset($star)}}" alt="">
		</div>
	@endif

	@if(isAdmin())
		<span class="btn-delete">
			{!! Form::open(['method' => 'Get', 'route' => ['products.edit', $post->id]]) !!}
				<button type="submit">Editar</button>
			{!! Form::close() !!}
			{!! Form::open(['method' => 'Delete', 'route' => ['products.destroy', $post->id]]) !!}
				<button type="submit">Borrar</button>
			{!! Form::close() !!}
		</span>
	@endif
	

	<div class="text">
		{{$post->details}}										
	</div>

	<div class="price">
		Precio {{'$'.$post->price}}				
	</div>

	<div class="prod_imagen_grande">
		<img src="{{ url("images/catalog/$post->file")}}" alt="">
	</div>		
	
	@include('partials.categories')			

	<div class="tags">@include('partials.tags_links')
	</div>
	<div class="inv">
		Cant. {{$post->inv}}			
	</div>		
	
	<div class="date">
		Creado : {{ $post->created_at}}					
	</div>
	@if(Auth::check())
		@include('partials.review_form')
	@endif
	
	<div class="show_reviews">
		<div class="review-title">Reseñas</div>
		@if (count($reviews) > 0)
			@foreach ($reviews as $review)
				<div class="one_review">
					titulo
					<div class="review-name">{{$review['name']}}</div>
					<div class="review-details">{{$review['details']}}</div>
					<div class="review-autor">{{$review['user_id']}}</div>
				</div>
			@endforeach
		@else 
			<div class="small-text">No hay Reseñas para este producto.</div>
		@endif	
	</div>

</div>


@endsection
