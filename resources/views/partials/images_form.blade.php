<div class="form-images">
	{!! Form::label('images', 'SUBE IMAGENES DE TU PRODUCTO') !!}
	{!! Form::file('images[]', null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
	@if ($errors->has('images.0'))
		<div class="single-error">
		{{ $errors->first('images.0') }}
		</div>
	@endif
	<span class="small-text"> *solo la 1 imagen es obligatoria, las demas son opcionales </span>
	{!! Form::file('images[]', null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
	{!! Form::file('images[]', null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
	{!! Form::file('images[]', null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}

{{-- 	@if ($errors->has($column))
		<div class="single-error">
		{{ $errors->first($column) }}
		</div>
	@endif --}}
</div>