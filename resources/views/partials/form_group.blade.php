<div class="form-group">
	{!! Form::label($column, $label) !!}
	{!! Form::$type($column, null, ['class' => 'form-control']) !!}
	@if ($errors->has($column))
		<div class="single-error">
		{{ $errors->first($column) }}
		</div>
	@endif
</div>