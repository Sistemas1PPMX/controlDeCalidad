
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" href="css\bootstrap.min.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="css\select2.min.css">
	<link href="css/bootstrap-select.css" rel="stylesheet">
</head>
<body>
	<div class="container-fluid p-0" style="width: 100vw; height: 100vh;">
		<div class="flex-row w-100">
			<nav class="navbar navbar-expand bg-primary m-0">	
				<div class="col-2">
					<a href="/" class="navbar-brand text-white">Control de calidad</a>			
				</div>
				<div class="col-8"></div>
				<div class="col-2 text-center p-0 align-bottom">
					<label class="text-center p-0 align-bottom align-text-bottom h-100 " style="font-family: 'Roboto', sans-serif; color: white;"><h4 id="usuario"></h4></label>
					<label id="supervisor" style="display: none;">{{Session::get('id')}}</label>
				</div>
			</nav>
		</div>
		<div class="container-fluid">
			<div class="row my-3">
				<div class="col-4">
					<div class="flex-row">
						Proyecto:
					</div>
					<div class="flex-row">
						<select id="proyecto">
							<option value="placeholder">--Placeholder--</option>	
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="flex-row">
						Pieza:
					</div>
					<div class="flex-row">
						<select id="pieza">
							<option value="placeholder">--Placeholder--</option>	
						</select>
					</div>
				</div>
				<div class="col-2">
					Lote:
					<input type="text" class="form-control" id="lote">
				</div>
				<div class="col-2 p-0">
					<button class="btn btn-primary btn-block h-100" id="guardar">Guardar lote</button>

				</div>
			</div>
			<div class="row">
				<table class="table table-bordered" id="tabla">
					<thead class="thead-dark">
						<tr>
							<th>Pieza</th>
							<th>Cantidad</th>
							<th>Para muestra</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>	
	</div>



	{!! Html::script('js\popper.js') !!}
	{!! Html::script('js\jquery-3.4.1.min.js') !!}
	<script src="js\bootstrap.min.js"></script>
	<script src="js\select2.min.js"></script>
	<script src="js\bootstrap-select.js"></script>
	<script src="js\lotePintura.js"></script>
</body>
</html>