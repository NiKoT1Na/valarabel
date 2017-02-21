<div>
	<div>
		Etiquetas
	</div>
	@foreach($post->tags as $tag)
		<span class="tag">
	@if (Route::currentRouteName() === 'category')
		<a href="{{ url('tag/' . $tag->id . '/category/'. $post->category->id) }}">{{$tag->name}}</a><span class="comma">, </span>
	@else
		<a href="{{ url('tag/' . $tag->id) }}">{{$tag->name}}</a><span class="comma">, </span>
	@endif

		</span>
	@endforeach
</div>