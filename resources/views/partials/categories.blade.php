<span class="category">
	@if (Route::currentRouteName() === 'tag')
		<a href="{{ url('tag/' . Request::route('tag') . '/category/' . $post->category->id) }}">{{$post->category->name}}</a>
	@else
		<a href="{{ url('category/' . $post->category->id) }}">{{$post->category->name}}</a>
	@endif
</span>
