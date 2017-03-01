<div class="cart">
	{{Form::open(['route' => ['shopping_cart'], 'class' => 'cart-selector'])}}
		{{Form::hidden("cart", $post->id)}}
		{!! Form::submit('') !!}
		<img src="{{Url::asset('/body/cart.png')}}" alt="">

	{!! Form::close() !!}
</div>
