@extends('layouts.app')

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
						<img src="{{ url("images/catalog/".json_decode($post->file)[0])}}" alt="">
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
					<div class="price">
						<?php $price = $post->price; ?>
						${{$price}}
	    				{!! Form::hidden("price[$key]", $price) !!}
					</div>
				</td>									
				<td class="amount">    				
    				{!! Form::number("amount[$key]", 1, ['max' => $post->inv, 'min' => 1]) !!}
				</td>
		
			{{-- </div> --}}
			</tr>
	@endforeach
	<tr>
		<td><h1>TOTAL</h1></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td class="cart-total">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<div>
	{!! Form::label('adress', 'direccion') !!}
	{!! Form::text('adress', null,  ['class' => 'form-adress']) !!}
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

</div>
   	{!! Form::submit('COMPRAR') !!}

{!! Form::close() !!}
@endif
@endsection