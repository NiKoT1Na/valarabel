<div class="tag_filter">
	<div class="lil-title">Filtra por Etiquetas
	</div>
	<div class="small-text">
			{{Form::open(['route' => ['post_filter'], 'class' => 'tag-selector'])}}
				@foreach($tags as $tag)
					<div class="tag-selected">
						{!! Form::label('one_tag_' . $tag->id, $tag->name) !!}
						{!! Form::checkbox('tag[]', $tag->id, false, ['class' => 'tag-selector', 'id' => 'one_tag_'.$tag->id]) !!}
					</div>
				@endforeach
				@if (Route::currentRouteName() === 'category'):
					{{Form::hidden('category_id', Request::route('category'))}}
				@elseif (Request::get('category_id'))
					{{Form::hidden('category_id', Request::get('category_id'))}}
				@endif
				{!! Form::submit('Filtrar') !!}
			{!! Form::close() !!}
	</div>
</div>
		