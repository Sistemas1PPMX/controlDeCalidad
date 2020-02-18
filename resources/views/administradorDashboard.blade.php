<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" href="css\bootstrap.min.css" type="text/css">
</head>
<body>
	<div class="container-fluid p-0" style="height: 100vh;">
		<div class="navbar w-100 bg-primary" style="height: 5%;">
			
		</div>
		<div class="flex-row p-0 d-flex" style="height: 95%; width: 100%;">
			<div class="col-1 bg-primary" style="height: 100%;">
				<div class="row" style="height: 10%;"></div>
				<div class="row"><button class="btn btn-link text-white" id="btnPiezas">Piezas</button></div>
				<div class="row"><button class="btn btn-link text-white" id="btnFallas">Fallas</button></div>
				<div class="row"><button class="btn btn-link text-white" id="btnUsuarios">Usuarios</button></div>
			</div>
			<div class="col-11" style="height: 100%;" id="contenedor">

			</div>
		</div>
	</div>


	{!! Html::script('js\popper.js') !!}
	{!! Html::script('js\jquery-3.4.1.min.js') !!}
	<script src="js\bootstrap.min.js"></script>
	<script src="js\administrador.js"></script>
</body>
</html>