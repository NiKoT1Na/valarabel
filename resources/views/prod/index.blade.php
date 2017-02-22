@extends('layouts.app')

@section('content')


<div class="img-header">
	<a href="{{ url('/products/') }}"> <img src="{{URL::asset('/body/TITLE.png')}}" alt=""> </a>
</div>


{{-- <div class="title">
	productos 
</div> --}}
<span class="route">
	@if (!empty($category))
		<a href="{{ url('/products/') }}"> INDEX &nbsp; </a>
		{{" > " . $category}}
	@endif
</span>

	
<div class="columns">
	<div class="side-menu">
		@include('partials.category_menu')	
		@include('partials.tag_filter')
	</div>

	<div id="subcontainer">
		@foreach($content as $post)
			<div class="product">
				
				<div class="name titulo-bonito">
					<a href="{{ url("products/$post->id") }}"> {{$post->name}} </a>
				</div>
	
				<div class="text">
					<h1>Detalles</h1>
					{{$post->details}}								
				</div>	
	
				<div class="price">
					Precio
					${{$post->price}}		
				</div>

				@if (Auth::user())
					@include('partials.cart')
				@endif	
	
				<div class="prod_imagen">
					<img src="{{ url("images/catalog/$post->file") }}" alt="">
				</div>
				
				@include('partials.categories')			
	
				<div class="tags">@include('partials.tags_links')
				</div>
				
				<div class="inv">
					cantidad disponible
					{{$post->inv}}
					unidades
				</div>	
				
				<div class="date">
					Creado
					{{$post->created_at}}
				</div>

	
	
			</div>
		@endforeach
		@for($i=0;$i<10;$i++)
	
			<div class="product">
				{{-- This is a fix, for the flex justify space-between issue
				it can be found here http://codepen.io/dalgard/pen/Dbnus --}}
			</div>	
		@endfor 		
	</div>
</div>
@endsection
