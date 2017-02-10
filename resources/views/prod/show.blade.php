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
		<div class="product">
			
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
			
	{{-- 		<div class="type">
				{{$post->categories}}				
			</div>		
			
			<div class="tag">
				{{$post->tags}}				
			</div>		 --}}
			
			<div class="inv">
				{{$post->inv}}			
			</div>		
			
			<div class="date">
				{{$post->created_at}}					
			</div>
		</div>				


</disv>
@endsection
