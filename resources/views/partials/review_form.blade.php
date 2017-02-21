<div class="titulo-bonito">Danos tu mejor reseña</div>

{!! Form::open(['action' => ['ReviewController@newreview', $post->id], 'class' => 'new_review']) !!}

	<div class="form-group">
		{!! Form::label('name', 'Titulo de la reseña') !!}
		{!! Form::text('name', null, ['class' => 'form-review']) !!}
	</div>		
	<div class="form-group">
		{!! Form::label('details', 'Reseña') !!}
		{!! Form::textarea('details', null, ['class' => 'form-review']) !!}
	</div>
	<div class="form-group">
		{!! Form::label('rating', 'Calificacion', ['class' => 'title']) !!}
		1 {!! Form::radio('rating', '1', false, ['class' => 'form-review']) !!}
		2 {!! Form::radio('rating', '2', false, ['class' => 'form-review']) !!}
		3 {!! Form::radio('rating', '3', true, ['class' => 'form-review']) !!}
		4 {!! Form::radio('rating', '4', false, ['class' => 'form-review']) !!}
		5 {!! Form::radio('rating', '5', false, ['class' => 'form-review']) !!}
	</div>

	<div>
		{!! Form::submit('Crear reseña') !!}
	</div>
{!! Form::close() !!}