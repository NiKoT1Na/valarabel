{{Form::open(['route' => ['post_filter'], 'class' => '', 'method'=> 'GET'])}}
	{!! Form::number('minprice', null, ['placeholder' => 'Precio minimo']) !!}
	{!! Form::number('maxprice', null, ['placeholder' => 'Precio maximo']) !!}
	{!! Form::submit('filtrar') !!}
{!! Form::close() !!}


