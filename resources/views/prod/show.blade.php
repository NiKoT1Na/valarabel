@extends('layouts.app')

@section('content')


@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
@endif
<div id="oneprod">
	<div class="right-panel"><div class="name-prod titulo-bonito">
			{{$post->name}}
		</div>
		@if(isAdmin())
			<span class="btns">
				{!! Form::open(['method' => 'Get', 'route' => ['products.edit', $post->id]]) !!}
					<button type="submit">Editar</button>
				{!! Form::close() !!}
				{!! Form::open(['method' => 'Delete', 'route' => ['products.destroy', $post->id]]) !!}
					<button type="submit">Borrar</button>
				{!! Form::close() !!}
			</span>
		@endif
		<div class="text-columns">
			@if ($rating)
				<div class="score">
					<img src="{{URL::asset($star)}}" alt="puntaje {{$rating}}" title="{{$rating}}/5">
				</div>
			@endif
			<div class="price">
				Precio {{'$'.$post->price}}				
			</div>
		</div>

		<div class="text">
			{{$post->details}}										
		</div>
	</div>
	<div class="left-panel">
	<div class="four-thumbnails">
		<a class="thumbnail"><img src="http://placehold.it/100x100" alt=""></a>
		<a class="thumbnail"><img src="http://placehold.it/100x100" alt=""></a>
		<a class="thumbnail"><img src="http://placehold.it/100x100" alt=""></a>
		<a class="thumbnail"><img src="http://placehold.it/100x100" alt=""></a>
	</div>
		<div class="prod_imagen_grande">
			<img src="{{ url("images/catalog/$post->file")}}" class="image_to_zoom">
		</div>		
	</div>
{{-- 	<div class="inv">
		Cant. {{$post->inv}}			
	</div>	 --}}	
	
	
	<div class="show_reviews">
		<div class="review-title">Reseñas</div>
		@if (count($reviews) > 0)
			@foreach ($reviews as $review)
				@if ($review->aproved === 1)
					<div class="one_review">
						<div class="review-name">{{$review['name']}}</div>
						<div class="review-details">{{$review['details']}}</div>
						<div class="review-autor">{{$review['user_id']}}</div>
						{!! Form::open(['route' => ['denied']]) !!}
							{{Form::hidden('review_id', $review['id'])}}	
	   						{!! Form::submit('Borrar') !!}
	   					{!! Form::close() !!}
					</div>
				@else 
					<div class="small-text">reseña pendiente de aprovacion</div>
				@endif

			@endforeach
		@else 
			<div class="small-text">No hay Reseñas para este producto.</div>
		@endif	
		@if(Auth::check())
			@include('partials.review_form')
		@endif
	</div>

</div>
<div class="overlay">
	<img src="" class="zoomed"  alt="">
	<button class="close"> X </button>
</div>
<script>
$(function () {


	function imageZoom(){
		$('.zoomed').attr('src', this.src);
		$('.overlay').fadeIn();
	}

	$('.overlay > button.close').click(function () {
		$('.overlay').fadeOut();
	});

	// $('.zoomed').mouseleave(function () {
	// 	$('.overlay').fadeOut();
	// });

	function imageOriginal(){
		// $('.overlay').css({'display': 'none'});	
	}

	$(".image_to_zoom").click(imageZoom);
	// $(".overlay .zoomed-clone").mouseleave(imageOriginal);
	$(".new_review").submit(function(){
		$.post(this.action, $(".new_review").serialize(), function(){
			
		});
	})

});
</script>


@endsection
