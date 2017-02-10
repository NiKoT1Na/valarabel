<!DOCTYPE HTML>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
<link rel="stylesheet" href="{{URL::asset('css/reset.css') }}" />
<link rel="stylesheet" href="{{URL::asset('css/valerie.css') }}" />
<meta charset="utf-8">
<title>Valerie 2.0</title>

</head>

<body>

<div id="upbar">
	este es el <a href="">login</a> , pero no sirve y que	
</div>


<div id="wrapper">

	<div id="links">
	
	</div>

	<div id="content">

	que onda mancos

{{-- 	@foreach(ProdController()->$content as $post)
		<div class="product">
			<div class="name">
				{{$post['name']}};
			</div>

			<div class="text">
				{{$post['details']}};				
			</div>
			
		</div>
	@endforeach --}}

	@foreach($content as $post)
		<div class="product">
			<div class="name">
				{{$post['name']}};
			</div>

			<div class="text">
				{{$post['details']}};				
			</div>
			
		</div>
	@endforeach
		
	</div>


</div>

</body>
</html>