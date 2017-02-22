<div class="cart">
	{{Form::open(['route' => ['shopping_cart'], 'class' => 'cart-selector'])}}
		{!! Form::label('one_shop' . $post->id, $post->name) !!}
		{{Form::hidden("cart", $post->id)}}
		{!! Form::submit('añadir') !!}
		<img src="{{Url::asset('/body/cart.png')}}" alt="">

	{!! Form::close() !!}
</div>
