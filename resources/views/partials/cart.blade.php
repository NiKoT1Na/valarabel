<div class="cart">
	{{Form::open(['route' => ['shopping_cart'], 'class' => 'cart-selector'])}}
		{{Form::hidden("cart", $post->id)}}
		{!! Form::submit('') !!}
	{!! Form::close() !!}
</div>
