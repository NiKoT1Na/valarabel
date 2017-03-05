<div class="category-filter">
	<div class="lil-title">Categorias</div>
	<div class="small-text">
		@foreach($categories as $one_category)
			@if (isset($category) && $category === $one_category->name)
				<a class="side-links current">{{$one_category->name}}</a>
			@else
				<a class="side-links" href="{{ url('category/' . $one_category->id) }}">  {{$one_category->name}} </a>
			@endif
		@endforeach
	</div>
	<script src="{{URL::asset('js/category_menu.js')}}"></script>
</div>