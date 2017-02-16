@extends('layouts.app')

@section('content')

<div class="title">
	productos <br>
</div>
@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
@endif
<div id="oneprod">
	
	<div class="name titulo-bonito">
		{{$post->name}}
	</div>

	<div class="file">
		{{$post->file}}				
	</div>			
	
	<div class="text">
		{{$post->details}}										
	</div>

	<div class="price">
		{{$post->price}}				
	</div>

	<div class="prod_imagen_grande">
		<img src="{{ url("images/catalog/$post->file")}}" alt="">
	</div>		
	
	@include('partials.categories')			

	<div class="tags">@include('partials.tags_links')
	</div>
	<div class="inv">
		{{$post->inv}}			
	</div>		
	
	<div class="date">
		{{$post->created_at}}					
	</div>
	@include('partials.review_form')
	
	<div class="show_reviews">
		<div class="review-title">Reseñas</div>
		@foreach ($reviews as $review)
			<div class="one_review">
				titulo
				<div class="review-name">{{$review->name}}</div>
				<div class="review-details">{{$review->details}}</div>
				<div class="review-autor">{{$review->user_id}}</div>
			</div>	
		@endforeach
	</div>

</div>

@endsection
