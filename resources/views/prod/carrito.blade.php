@extends('layouts.app', ['body_class' => 'carrito'])

@section('content')

@if ($content->count() === 0)
	<span> aun no has añadido elementos a tu carrito </span>
@else
{!! Form::open(['route' => ['shopping']]) !!}
<table>
	{{-- @if (!empty($content))
		<div>
			{{"No tienes productos en tu carrito actualmente"}}
		</div>
	@else --}}
		<tr>
			<th>&nbsp;</th>
			<th>Nombre</th>
			<th>Rating</th>
			<th>Precio</th>
			<th>Categoria</th>
			<th>Etiquetas</th>
			<th>Cantidad</th>
		</tr>

	{{-- @endif --}}
		
	@foreach ($content as $key => $post)	
		{{-- {{$post->name}}		 --}}
			
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			<tr>
				<td>
					<div class="small">
						<img src="{{ url("images/catalog/$post->file")}}" alt="">
					</div>		
				</td>
				<td>
					<div>
						<div class="name titulo-bonito">
							<a href="{{ url("products/$post->id") }}"> {{$post->name}} </a>
						</div>
					</div>
				</td>

				<td>
					<div>
						<div class="tiny">
							<img src="{{URL::asset($stars[$key])}}" alt="">
						</div>
					</div>
				</td>

				<td>
					<div>
						<?php $price = $post->price; ?>
						${{$price}}
	    				{!! Form::hidden('price[]', $price) !!}
					</div>
				</td>					
				<td class="table-tags"> 
					<div>
						@include('partials.categories')
					</div>
				</td>		
				<td class="table-tags">
					<div>
						@include('partials.tags_links')
					</div>
				</td>
				<td>    				
    				{!! Form::number('amount[]', 'cantidad') !!}
				</td>
		
			{{-- </div> --}}
			</tr>
	@endforeach
</table>

<div>
	{!! Form::label('adress', 'direccion') !!}
	{!! Form::text('adress', null, ['class' => 'form-adress']) !!}
</div>

<div>
	{!! Form::label('telephone', 'telefono') !!}
	{!! Form::text('telephone',null, ['class' => 'form-telephone']) !!}
</div>

<div>
	{!! Form::label('notes', 'Notas sobre la entrega') !!}
</div>
<div>
	{!! Form::textarea('notes',null, ['class' => 'form-notes']) !!}
</div>
<div>
	<h1>TOTAL</h1>
	{{"$" . $sum}}
</div>
   	{!! Form::submit('COMPRAR') !!}

{!! Form::close() !!}
@endif
@endsection