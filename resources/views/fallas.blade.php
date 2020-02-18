@extends('layouts.dump')
@section('content')
	<div class="flex-row" style=" height: 96vh;">
		<div class="col-6 offset-3 p-0" style="height: 100%; ">
			<div class="flex-row" style="height: 10%; "></div>
			<div class="flex-row text-center" style="height: 10%; ">
				<label style="height: 100%; "><h1>Sistema de reporte de fallas en la aplicación</h1></label>
			</div>
			<div class="flex-row">
				<label><h2>Nombre:</h2></label>
				<input type="text" id="nombre" class="form-control">
			</div>
			<div class="flex-row">
				<label><h2>Modulo:</h2></label>
				<select class="form-control" id="area">
					
				</select>
			</div>
			<div class="flex-row" style="height: 50%;">
				<label><h2>Descripcion del error:</h2></label>
				<textarea class="form-control" id="descripcion" style="height: 85%"></textarea>
			</div>
			<button class="btn btn-primary btn-block mt-5" id="btnEnviar">Enviar</button>	
		</div>
	</div>
@endsection
@section('scripts')
{!! Html::script('js\reporteFallas.js') !!}
@endsection