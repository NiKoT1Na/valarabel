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

	<title>{{ config('app.name', 'Laravel') }}</title>

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
<body>
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

						<a href="{{ url('/products/create') }}">SUBIR</a>            
					</span>

				   {{--  <ul class="nav navbar-nav">
						&nbsp;
					</ul>
 --}}
					<!-- Right Side Of Navbar -->
					<span class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@if (Auth::guest())
							<span class="left_menu_bar"><a href="{{ url('/login') }}">Login</a>
							<a href="{{ url('/register') }}">Register</a></span>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="{{ url('/logout') }}"
											onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
											Logout
										</a>

										<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</li>
								</ul>
							</li>
						@endif
					</span>
				</div>
			</div>            
		</nav>

		@yield('content')
	  
	</div>

	<!-- Scripts -->
	<script src="{{URL::asset('js/app.js')}}"></script>
</body>
</html>
