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
			{!! Form::open(['route' => 'products.store', 'method', 'files' => true]) !!}
				
				@include('partials.form_group', ['column'=> 'name', 'type' => 'text', 'label' => 'NOMBRE DEL PRODUCTO'])

				@include('partials.form_group', ['column'=> 'details', 'type' => 'textarea', 'label' => 'DESCRIPCION'])

				@include('partials.form_group', ['column'=>'file', 'type' => 'file', 'label' => 'IMAGEN DE TU PRODUCTO'])

			    <div class="form-group">
					{!! Form::label('categories', 'CATEGORIA') !!}
					{!! Form::select('categories', $category_array) !!}
					@if ($errors->has('categories'))
						<div class="single-error">
						{{ $errors->first('categories') }}
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

