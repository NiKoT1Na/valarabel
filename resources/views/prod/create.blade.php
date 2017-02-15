@extends('layouts.app')

@section('content')

{{-- @if (!isset($id))
	{{ $fill = ["", "", "", "", "", ""]}}
@endif
 --}}	
		<div class="title">
			sube tu producto
		</div>


		<div id="editpage">
			@if (isset($prod))
				{!! Form::model($prod, ['route' => ['products.update', $prod->id ], 'method' => 'PUT', 'files' => true]) !!}
				{{ $prod->tags = implode(', ', $prod->tags->pluck('name')->all()) }}

			@else
				{!! Form::open(['route' => 'products.store', 'method', 'files' => true]) !!}
			@endif
				
				@include('partials.form_group', ['column'=> 'name', 'type' => 'text', 'label' => 'NOMBRE DEL PRODUCTO'])

				@include('partials.form_group', ['column'=> 'details', 'type' => 'textarea', 'label' => 'DESCRIPCION'])

				@include('partials.form_group', ['column'=>'file', 'type' => 'file', 'label' => 'IMAGEN DE TU PRODUCTO'])

				<div class="form-group">
					{!! Form::label('category_id', 'CATEGORIA') !!}
					{!! Form::select('category_id', $category_array) !!}
					@if ($errors->has('category_id'))
						<div class="single-error">
						{{ $errors->first('category_id') }}
						</div>
					@endif	
				</div>
				@include('partials.form_group', ['column'=> 'tags', 'type' => 'text', 'label' => 'ETIQUETAS'])

				<div class="small_text">Separadas por comas ","</div>

				@include('partials.form_group', ['column'=> 'price', 'type' => 'number', 'label' => 'PRECIO'])

				@include('partials.form_group', ['column'=> 'inv', 'type' => 'number', 'label' => 'INVENTARIO'])

				<div>
					{!! Form::submit('Subir') !!}
				</div>

			{!! Form::close() !!}
		</div>
					
	
	
@endsection

