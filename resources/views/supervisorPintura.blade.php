<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css\bootstrap.min.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="css\select2.min.css">
	<link rel="stylesheet" type="text/css" href="css\disable.css">
	<link href="css/bootstrap-select.css" rel="stylesheet">
	<link href="css/keypad.css" rel="stylesheet">

	<style type="text/css">
		#pieza{
			width: 100px;
		}

	</style>
</head>
<body>
	<div class="container-fluid p-0" style="width: 100vw; height: 100vh;">
		<div class="flex-row m-0" style="height: 5%">
			<nav class="navbar navbar-expand bg-primary" style="width: 100%; height: 100%">	
				<div class="col-2">
					<a href="/" class="navbar-brand text-white">Control de calidad</a>			
				</div>
				<div class="col-8">
					<label id="supervisor" style="display: none;">{{Session::get('id')}}</label>
				</div>
				<div class="col-2 text-center ">
					<button class="btn btn-danger btn-block" id="btnLogout">Logout</button>
				</div>
			</nav>	
		</div>
		<div class="flex-row m-0 d-flex" style="height: 20%">
			<div class="col-4" style="height: 100%;">
				<div class="row h-50 p-0">
					<div class="row h-50 w-100 m-0"><h2 class="w-100 text-center">PIEZA:</h2></div>
					<div class="row h-50 w-100 m-0">
						<select id="pieza" class="form-control w-100">
							<option value="placeholder">--pieza--</option>
						</select>
					</div>
				</div>
				<div class="row h-50">
				</div>
			</div>
			<div class="col-4" style="height: 100%;">
				<div class="row h-50 p-0">
					<div class="row h-50 w-100 m-0"><h2 class="w-100 text-center">LOTE:</h2></div>
					<div class="row h-50 w-100 m-0">
						<input type="text" id="lote" class="form-control w-100 m-0">
					</div>
				</div>
				<div class="row h-50">
				</div>
			</div>
			<div class="col-4 p-0" style="height: 100%;">
				<button class="btn btn-success btn-block h-100" id="btnGuardar"><h1>Guardar Lote</h1></button>
			</div>
		</div>
		<div class="flex-row" style="height: 75%">
			<table class="table table-bordered" id="tabla">
				<thead class="thead-dark">
					<tr>
						<th scope="col">--</th>
						<th scope="col">Pieza</th>
						<th scope="col" style="width: 20%">--</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>	
	
	
	{!! Html::script('js\popper.js') !!}
	{!! Html::script('js\jquery-3.4.1.min.js') !!}



	<script src="js\bootstrap.min.js"></script>
	<script src="js\select2.min.js"></script>
	<script src="js\bootstrap-select.js"></script>

	@yield('scripts')

	{!! Html::script('js\supervisorPintura.js') !!}
</body>
</html>

