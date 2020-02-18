<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css\bootstrap.min.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="css\select2.min.css">
	<link rel="stylesheet" type="text/css" href="css\disable.css">
	<link href="css/bootstrap-select.css" rel="stylesheet">
	<link href="css/keypad.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">

	<style type="text/css">
		#pieza{
			width: 100px;
		}

		.modal-lg {
			max-width: 80% !important;
		}

	</style>
</head>
<body>
	<div class="container-fluid p-0" style="width: 100vw; height: 100vh;">
		<nav class="navbar navbar-expand bg-primary" style="width: 100%">	
			<div class="col-2">
				<a href="/" class="navbar-brand text-white">Control de calidad</a>			
			</div>
			<div class="col-8"></div>
			@yield('navbar') 
		</nav>	
		@yield('content')
	</div>	
	
	
	{!! Html::script('js\popper.js') !!}
	{!! Html::script('js\jquery-3.4.1.min.js') !!}



	<script src="js\bootstrap.min.js"></script>
	<script src="js\select2.min.js"></script>
	<script src="js\bootstrap-select.js"></script>

	@yield('scripts')

</body>
</html>

{{-- <div class="container-fluid" style="width: 100vw;">
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="width: 100%">
		<div class="container-fluid">
			<div class="col2">
				<a href="/" class="navbar-brand">Control de calidad</a>			
			</div>
			<div class="col-8"></div>
			@yield('navbar') 
		</div>
	</nav>	
</div>	 --}}