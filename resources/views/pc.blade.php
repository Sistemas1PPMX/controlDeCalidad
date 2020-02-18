@extends('layouts.dump')
@if(Session::has('id'))
@section('navbar')
<div class="col-2 text-center p-0 align-bottom">
	<label class="text-center p-0 align-bottom align-text-bottom" style="font-family: 'Roboto', sans-serif; color: white;"><h2 id="usuario"></h2></label>
</div>
@endsection()			
@section('content')
<div class="flex-row">
	<label id="inspector" hidden="true">{{Session::get('id')}}</label>
	{{-- 	<label class="col-form-label"><h4>{{Auth::user()->name}} </h4></label> --}}	
</div>
<div id="principal">
	<div class="flex-row d-flex" style="height: 10%;">
		<div class="col-4 h-100">
			<div class="row h-50"><h2 class="w-100 text-center">Lote:</h2></div>
			<div class="row h-50">
				<select class="form-control" id="lote">
					<option value="placeholder">--lote--</option>
				</select>
			</div>
		</div>
		<div class="col-4 h-100">

		</div>
		<div class="col-4 h-100">
			<button class="btn btn-block btn-primary">Guardar</button>
		</div>
	</div>
	<div class="flex-row" style="height:82%;">
		<table id="tablainfo" class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th style="width: 25%">PIEZA</th>
					<th style="width: 20%"><input type="button" id="btnPreparacion" class="btn btn-primary btn-block" value="PREPARACION"></th>
					<th style="width: 20%"><input type="button" id="btnC1" class="btn btn-primary btn-block" value="CAPA 1"></th>
					<th style="width: 20%"><input type="button" id="btnC2" class="btn btn-primary btn-block" value="CAPA 2"></th>
					<th style="width: 20%"><input type="button" id="btnC3" class="btn btn-primary btn-block" value="CAPA 3"></th>
					<th style="width: 15%">OBSERVACION</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="container-fluid" id="revision" style="display: none; height: 40vh;"> 
	<div class="row flex-row m-5" id="infoRevision" style="height: 5vh">
		{{-- <div class="col-3">
			PIEZAS APROBADAS: <input type="number" class="form-control soloNumeros" id="piezasAprobadas">
		</div>
		<div class="col-3">
			MUESTRA: <input type="number" class="form-control" id="paraAprobar" readonly="true">	
		</div> --}}
		<div class="col-3">
			<button class="btn btn-danger btn-block" style="height: 100%;" id="btnObservacion">OBSERVACION</button>
		</div>
		<div class="col-3">
			<button class="btn btn-success btn-block" style="height: 100%" id="btnAceptar">ACEPTAR PIEZA</button>
			{{-- <button class="btn btn-success btn-block" style="height: 100%; visibility: hidden;" id="btnGuardar">Guardar Revision</button> --}}
		</div>
		<div class="col-3">
			<button class="btn btn-success btn-block" style="height: 100%" id="btnRechazar">RECHAZAR PIEZA</button>
		</div>
		<div class="col-3">
			<button class="btn btn-warning btn-block" style="height: 100%" id="btnRegresarRevision">REGRESAR</button>
		</div>
	</div>
	<div class="flex-row">
		<label>COMENTARIO APROBACION: </label>
		<input type="text" id="comentarioParcial" class="form-control">
	</div>
	<div class="row flex-row m-4" id="formObservacion" style="visibility: hidden">
		<span class="" style="width: 100%;">
			<div class="row flex-row">
				<label>FORMULARIO DE FALLA</label>
				<label class="offset-5">PIEZA ACTUAL:</label>
				<label id="piezaActual"></label>
			</div>
			<div class="row flex-row">
				<div class="col-2">
					<div class="row flex-row">
						DEFECTO: 	
					</div>
					<div class="row flex-row">
						{!! Form::select('defecto',['placeholder'=>'--Seleccione--'],null,['id' => 'defecto']) !!}
					</div>
				</div>
				<div class="col-3">
					DESCRIPCION:
					<input type="text" id="descripcion" class="form-control">
				</div>
				<div class="col-2">
					<div class="row -flex-row">
						SUPERVISOR QUE INDICA:
					</div>
					<div class="row -flex-row">
						<select class="form-control" id="supervisor" value="placeholder">
							<option>--Supervisor--</option>
						</select>
					</div>
					{{-- {!! Form::select('supervisor',['placeholder'=>''],null,['id'=>'supervisor'])!!} --}}
				</div>
				<div class="col-2">
					<div class="row -flex-row">
						INDICACIÓN:						
					</div>
					<div class="row -flex-row">
						<select class="form-control" id="indicacion" value="placeholder">
							<option>--Indicacion--</option>
						</select>

					</div>
					{{-- {!! Form::select('indicacion',['placeholder'=>''],null,['id'=>'indicacion'])!!} --}}
				</div>
				<div class="col-3">
					OBSERVACIONES: <input type="text" id="observaciones" class="form-control">
				</div>
			</div>
			<div class="row m-4" style="height: 60px;">
				<div class="col-3 offset-md-2">
					<button class="btn btn-secondary btn-block" style="height: 100%" id="btnAnadirFalla">AÑADIR FALLA</button>
				</div>
				<div class="col-3 offset-md-2">
					<button class="btn btn-primary btn-block" style="height: 100%" id="btnGuardarObservacion">GUARDAR OBSERVACIÓN</button>
				</div>
			</div>
		</span>
	</div>
	<div class="flex-row m-5">
		<div class="row" id="tabla">
			<table id="errores" class="table table-bordered" style="visibility: hidden;">
				<thead class="thead-dark">
					<tr>
						<th scope="col">PROYECTO</th>
						<th scope="col">PIEZA</th>
						<th scope="col">LOTE</th>
						<th scope="col">DEFECTO</th>
						<th scope="col">DESCRIPCION</th>
						<th scope="col">AREA</th>
						<th scope="col">SUPERVISOR</th>
						<th scope="col">INDICACIÓN</th>
						<th scope="col">OBSERVACIONES</th>
						<th scope="col" style="width: 15%;"></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endsection
@endif
@section('scripts')
{!! Html::script('js\pc.js') !!}
@endsection
