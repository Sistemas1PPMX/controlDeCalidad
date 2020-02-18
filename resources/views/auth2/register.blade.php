@extends('layouts.dump')
@section('navbar')

@endsection
@section('content')
<div class="col-6 offset-3">
	<div class="card" style="width: 100%">
		<div class="card-header">
			<div class="card-title text-center">
				<label><h2>Registro de nuevos usuarios</h2></label>
			</div>
		</div>
		<div class="card-body">
			<div class="row flex-row m-4">
				<div class="col-4">
					<label>Nombre(s): </label>
				</div>
				<div class="col-8">
					<input type="text" class="form-control" id="nombre">
					<div class="invalid-feedback"><label id="fdbNombre"></label></div>
				</div>				
			</div>
			<div class="row flex-row m-4">
				<div class="col-4">
					Apellido parterno: 
				</div>
				<div class="col-8">
					<input type="text" class="form-control" id="apellidoP">
					<div class="invalid-feedback"><label id="fdbApellidoP"></label></div>
				</div>
			</div>
			<div class="row flex-row m-4">
				<div class="col-4">
					Apellido materno: 
				</div>
				<div class="col-8">
					<input type="text" class="form-control" id="apellidoM">
					<div class="invalid-feedback"><label id="fdbApellidoM"></label></div>
				</div> 
			</div>
			<div class="row flex-row m-4">
				<div class="col-4">
					<label>Nip: </label>
				</div>
				<div class="col-8">
					<input type="password" class="form-control" id="nip">
					<div class="invalid-feedback"><label id="fdbNip"></label></div>
				</div>
			</div>
			<div class="row flex-row">
				<button class="btn btn-primary btn-block" id="btnRegistrase">Registrarse</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js\main.js') !!}
@endsection