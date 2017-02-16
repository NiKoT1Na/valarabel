<span>

	@foreach($post->tags as $tag)
		<span class="tag">
			<a href="{{url("tag/".$tag->id)}}">{{ $tag->name }}</a><span class="comma">, </span>
		</span>
	@endforeach
</span>