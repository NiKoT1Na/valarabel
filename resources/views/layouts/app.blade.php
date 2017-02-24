<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Economica" rel="stylesheet">
	<link rel="stylesheet" href="{{URL::asset('css/reset.css') }}" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{{ asset('body/favicon.png') }}}">

	<title>{{ config('app.name', 'Valerie Bisuteria') }}</title>

	<!-- Styles -->
	{{-- <link href="{{URL::asset('css/app.css')}}" rel="stylesheet" /> --}}
	<link rel="stylesheet" href="{{URL::asset('css/valerie.css') }}" />

	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
	</script>    
</head>
<body class="{{ $body_class or '' }}">
	<div class="errors">
		
	</div>
	
	<div> <img src="" alt=""> </div>

	<div id="app">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container">

				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
				   {{--  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> --}}

					<!-- Branding Image -->
				   {{--  <a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a> --}}
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<span class="center_menu">
						<a href="{{ url('/products/') }}">INDEX</a>            

						@if (isAdmin()) 
							<a href="{{ url('/products/create') }}">SUBIR</a>
							<a href="{{ url('/dashboard/'.Auth::user()->id)}}">DASHBOARD</a>
						@endif
						@if (Auth::guest())
							<span class="left_menu_bar"><a href="{{ url('/login') }}">Login</a>
							<a href="{{ url('/register') }}">Register</a></span>
						@else
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>
							<a href="{{ url('/logout') }}"
								onclick="event.preventDefault();
										 document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
							<a href="{{ url('/carrito') }}">Carrito
								{{-- <img src="{{Url::asset('/body/cart.png')}}" alt=""> --}}
								
							</a>

						@endif


					</span>

				   {{--  <ul class="nav navbar-nav">
						&nbsp;
					</ul>
 --}}
					<!-- Right Side Of Navbar -->					
				</div>
			</div>            
		</nav>

		@yield('content')
	  
	</div>

	<!-- Scripts -->
	<script src="{{URL::asset('js/app.js')}}"></script>
</body>
</html>
