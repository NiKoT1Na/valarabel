<div class="tag_filter">
	<div class="lil-title">Explora Etiquetas
	</div>
	<div class="small-text">
			{{Form::open(['route' => ['post_filter'], 'class' => 'tag-selector ajax-form', 'method'=> 'GET'])}}
				@foreach($tags as $key => $tag)
					<div class="tag-selected">
						{!! Form::checkbox("tag[$key]", $tag->id, Input::get("tag.{$key}"), ['class' => 'tag-selector', 'id' => 'one_tag_'.$tag->id]) !!}
						{!! Form::label('one_tag_' . $tag->id, $tag->name) !!}
					</div>
				@endforeach
				@if (Route::currentRouteName() === 'category')
					{{Form::hidden('category_id', Request::route('category'))}}
				@elseif (Request::get('category_id'))
					{{Form::hidden('category_id', Request::get('category_id'))}}
				@endif
			{!! Form::close() !!}
	</div>
	<script src="{{URL::asset('js/tag_filter.js')}}"></script>
</div>
		