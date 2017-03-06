@extends('layouts.app')

@section('content')

<div class="img-header">
	<a href="{{ url('/products/') }}"> <img src="{{URL::asset('/body/TITLE.png')}}" alt="" class="title-image"> </a>
</div>
		
	<div class="columns">
		<div class="side-menu">
			@include('partials.filter')
		</div>
		<div class="left-side">	
			<span class="route">
				@if (!empty($category))
					<a href="{{ url('/products/') }}"> INICIO &nbsp; </a>
					{{" > " . $category}}
				@endif
			</span>
		<div id="subcontainer">
			@foreach($content as $post)
				<div class="product">
					
					<div class="name titulo-bonito">
						<a href="{{ url("products/$post->id") }}">
							{{$post->name}}
							<span class="price">${{$post->price}}</span>
						</a>
					</div>
	
					@if (Auth::user())
						@include('partials.cart')
					@endif	
		
					<div class="prod_imagen">
						<img src="{{ url("images/catalog/".json_decode($post->file)[0]) }}" alt="">
					</div>
		
				</div>
			@endforeach
			
			@for($i=0;$i<10;$i++)
				<div class="product"></div>	
			@endfor 

			{{$content->links()}}
		</div>
	</div>
</div>
@endsection
