
<html>
<head>
	<title>Control calidad - @yield('tittle')</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	@if (session('status'))

	@else{
		<script>window.location = "/";</script>
	}@endif
	<div class="container">
		@yield('content')	
	</div>
</body>
</html>