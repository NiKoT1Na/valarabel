@extends('layouts.app')

@section('content')

<div class="title">
	productos 
</div>
<div id="subcontainer">
	
	@foreach($content as $post)
		<div class="product">
			
			<div class="name titulo-bonito">
				<a href="{{ url("products/$post->id") }}"> {{$post->name}} </a>
			</div>

			<div class="text">
				{{$post->details}}								
			</div>	

			<div class="price">
				{{$post->price}}		
			</div>	

			<div class="prod_imagen">
				<img src="{{ url("images/catalog/$post->file")}}" alt="">
			</div>
			
			<div class="type">
				
			</div>	
			
			<div class="tag">

				@foreach($tags as $tag)
					@if($tag->prod_id = $post->id)
					{!!$tag->tag_id." _ ".$tag->TAG_NAME."<br>"!!}
					@endif
				@endforeach
 			</div>	
			
			<div class="inv">
				{{$post->inv}}
			</div>	
			
			<div class="date">
				{{$post->created_at}}
			</div>
		</div>
	@endforeach		
</disv>
@endsection
