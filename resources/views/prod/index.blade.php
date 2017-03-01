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
					<a href="{{ url("products/$post->id") }}">
						{{$post->name}}
						<span class="price">${{$post->price}}</span>
					</a>
				</div>
				{{-- 
				<div class="text">
					<h1>Detalles</h1>
					{{$post->details}}								
				</div>	
				 --}}

				@if (Auth::user())
					@include('partials.cart')
				@endif	
	
				<div class="prod_imagen">
					<img src="{{ url("images/catalog/".json_decode($post->file)[0]) }}" alt="">
				</div>
				
				{{-- @include('partials.categories')			 --}}
	
				{{-- <div class="tags">@include('partials.tags_links')</div> --}}

				{{-- 
				<div class="inv">
					cantidad disponible
					{{$post->inv}}
					unidades
				</div>	
				 --}}

				{{-- 
				<div class="date">
					Creado
					{{$post->created_at}}
				</div>
				 --}}
	
	
			</div>
		@endforeach
		@for($i=0;$i<10;$i++)
	
			<div class="product"></div>	
		@endfor 
		{{-- @if ($content->currentPage() !== $content->firstItem())
			<a href="{{$content->previousPageUrl()}}">anterior</a>
		@endif
		@for($page = 1;$page<=$content->lastPage(); $page++)

			<a href="{{$content->url($page)}}">{{$page}}</a>
			
		@endfor
		@if ($content->currentPage() !== $content->lastPage())
			<a href="{{$content->nextPageUrl()}}">Siguiente</a>
		@endif --}}
		{{$content->links()}}
		<script> 
			$(function(){ 		
				$("body").on('click', '.pagination a', function(event){
					$("#subcontainer").html('<img class="loading" src="{{URL::asset('body/loading.gif') }}">');
					var url = this.href;
					$("#subcontainer").load(url + " #subcontainer > *");
					return false;						
				});
			})
		</script>
	</div>
</div>
@endsection
