{{Form::open(['route' => ['post_filter'], 'class' => 'ajax-form', 'method'=> 'GET'])}}
	<div class="lil-title filter-title">Filtra los productos</div>
	<div class="side-columns">
		<div class="category-filter">
			<div class="lil-title">Categorias</div>
				<div class="small-text">
					@foreach($categories as $key => $one_category)
						<div>
						{!! Form::radio("category", $one_category->id, false, [
							'id' => 'category_' . $key,
							'class' => 'category-selector']) !!}
						{!! Form::label("category_" . $key, $one_category->name ) !!}
						</div>
					@endforeach
					<div>
					{!! Form::radio("category", "") !!}
					{!! Form::label("category_all", 'TODAS' ) !!}
					</div>
				</div>
			</div>
			<div class="tag_filter">
				<div class="lil-title">Etiquetas
				</div>
				<div class="small-text">
					@foreach($tags as $key => $tag)
						<div class="tag-selected">
							{!! Form::checkbox("tag[$key]", $tag->id, Input::get("tag.{$key}"), ['class' => 'tag-selector', 'id' => 'one_tag_'.$tag->id]) !!}
							{!! Form::label('one_tag_' . $tag->id, $tag->name) !!}
						</div>
					@endforeach
				</div>
			</div>	
		<script src="{{URL::asset('js/filter.js')}}"></script>
	</div>
	<div class="price-filter">
		{!! Form::number('minprice', null, ['placeholder' => 'Precio minimo']) !!}
		{!! Form::number('maxprice', null, ['placeholder' => 'Precio maximo']) !!}
	</div>
	{!! Form::reset('Reset') !!}
	{!! Form::submit('filtrar') !!}
{!! Form::close() !!}
		