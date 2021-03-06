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
{{-- 	<label class="col-form-label"><h4>{{Auth::user()->name}} </h1></label>
--}}	</div>
<div class="container-fluid" id="preRevision">
	<div class="row flex-row m-4" id="selectores">
		<div class="col-4">
			<div class="row flex-row">
				PROYECTO:
			</div>
			<div class="row flex-row">
				{!! Form::select('contract',$contract,null,['id'=>'proyecto'])!!}
			</div>
		</div>
		<div class="col-4">
			<div class="row flex-row">
				PIEZA: 	
			</div>
			<div class="row flex-row">
				{!! Form::select('ContractItem',['placeholder'=>'--Pieza--'],null,['id'=>'pieza'])!!}
			</div>
		</div>
		<div class="col-2 text-center align-text-bottom">
			ÁREA: <label id="area">Corte y perforado</label>
		</div>
		<div class="col-2">
			<button class="btn btn-block btn-danger h-100" id="pintura">PARA PINTURA</button>
		</div>			
	</div>
	<div class="row flex-row m-4" id="informacion1">
		<div class="col-3">
			CANTIDAD: <input type="number" class="form-control" id="cantidad" class="quantity" readonly="true">	
		</div>
		<div class="col-3">
			PIEZAS RESTANTES: <input type="number" class="form-control" id="piezasRestantes" readonly="true">				
		</div>
		<div class="col-3 ">			
			PORCENTAJE DE APROBACIÓN:
			<div class="flex-row h-100 float">
				<input type="number" class="form-control" id="muestra" value="10" style="width: 80%"> <label>%</label>		
			</div>
		</div>
		<div class="col-3">
			LOTE: <input type="number" class="form-control" id="lote">	
		</div>
	</div>
	<div class="row flex-row m-4" id="informacion2">
		<div class="col-3">
			REVISADAS: <input type="number" class=" form-control" id="revisadas" readonly="true">	
		</div>
		<div class="col-3">
			PIEZAS RECHAZADAS: <input type="number" class="form-control" id="piezasRechazadas" readonly="true">	
		</div>
		<div class="col-3 ">
			ACEPTADAS: <input type="number float-right" class="form-control" id="aceptadas" readonly="true">
		</div>
		<div class="col-3">
			NÚMERO DE OBSERVACIÓN
			<select id="piezaOB" class="dropdown">
				<option value="placeholder">--con OB--</option>
			</select>
		</div>
	</div>
</div>
<div class="row flex-row m-4" id="botonesInfo">
	<div class="col-2">
		<button class="btn btn-primary btn-block" id="btnNuevaRevision">REGISTRO</button>
	</div>

</div>

<!--Formulario de revision-->
<div class="container-fluid" id="revision" style="display: none">
	<div class="row flex-row m-5" id="infoRevision">
		<div class="col-6">
			<div class="flex-row">
				<div class="col-6">
					PIEZAS APROBADAS: <input type="number" class="form-control soloNumeros" id="piezasAprobadas">
				</div>
				<div class="col-6">
					MUESTRA: <input type="number" class="form-control" id="paraAprobar" readonly="true">	
				</div>
			</div>
			<div class="flex-row">
				
			</div>
		</div>
		<div class="col-2">
			<button class="btn btn-danger btn-block" style="height: 100%;" id="btnObservacion">OBSERVACION</button>
		</div>
		<div class="col-2">
			<button class="btn btn-success btn-block" style="height: 100%" id="btnAceptar">ACEPTAR PIEZA</button>
			{{-- <button class="btn btn-success btn-block" style="height: 100%; visibility: hidden;" id="btnGuardar">Guardar Revision</button> --}}
		</div>
		<div class="col-2">
			<button class="btn btn-warning btn-block" style="height: 100%" id="btnRegresarRevision">REGRESAR</button>
		</div>
	</div>
	<div class="flex-row" id="formObservacion" style="visibility: hidden;height: 25%;">
		<div class="flex-row d-flex">
			<label>FORMULARIO DE FALLA</label>
			<label class="offset-5">PIEZA ACTUAL:</label>
			<label id="piezaActual"></label>
		</div>
		<div class="flex-row d-flex" style="height: 40%;">
			<div class="col-4" style="height: 100%">
				<div class="flex-row" style="height: 50%;">
					DEFECTO: 	
				</div>
				<div class="flex-row" style="height: 50%">
					{!! Form::select('defecto',['placeholder'=>'--Seleccione--'],null,['id' => 'defecto']) !!}
				</div>
			</div>
			<div class="col-4" style="height: 100%">
				<div class="flex-row" style="height: 50%">
					DESCRIPCION:
				</div>
				<div class="flex-row" style="height: 50%">
					<input type="text" id="descripcion" class="form-control">
				</div>
			</div>
			<div class="col-4">
				AREA CARGADA:
				<SELECT class="form-control" id="areaCargada">
					<option value="4">CORTE Y PERFORADO</option>
					<option value="5" selected="true">ARMADO</option>
					<option value="6">SOLDADURA</option>
				</SELECT>
			</div>
		</div>
		<div class="flex-row d-flex">
			<div class="col-4" style="height: 100%">
				<div class="flex-row" style="height: 50%">
					SUPERVISOR QUE INDICA:
				</div>
				<div class="flex-row" style="height: 50%">
					<select class="form-control" id="supervisor" value="placeholder">
						<option>--Supervisor--</option>
					</select>
				</div>
				{{-- {!! Form::select('supervisor',['placeholder'=>''],null,['id'=>'supervisor'])!!} --}}
			</div>
			<div class="col-4" style="height: 100%">
				<div class="flex-row" style="height: 50%">
					INDICACIÓN:						
				</div>
				<div class="flex-row" style="height: 50%">
					<select class="form-control" id="indicacion" value="placeholder">
						<option>--Indicacion--</option>
					</select>
				</div>
				{{-- {!! Form::select('indicacion',['placeholder'=>''],null,['id'=>'indicacion'])!!} --}}
			</div>
			<div class="col-4" style="height: 100%">
				<div class="flex-row" style="height: 50%">
					OBSERVACIONES:
				</div>
				<div class="flex-row" style="height: 50%">
					<input type="text" id="observaciones" class="form-control">
				</div>
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
<div class="container-fluid h-100" id="tablaErrores" style="display: none;">
	<div class="row ml-4 mr-4">
		<div class="col-4">
			<button class="btn btn-primary h-100 btn-block" id="rerevision">RE-REVISIÓN</button>
		</div>
		<div class="col-6">
			<button class="btn btn-success btn-block h-100 rerevision" id="btnEliminaFalla" style="visibility: hidden;">LIBERAR FALLAS SELECCIONADAS</button>
		</div>
		<div class="col-2  rerevision">
			<button class="btn btn-warning btn-block h-100 rerevision" id="btnRegresarFallas">REGRESAR</button>
		</div>
	</div>
	<div class="row m-4">
		<table id="erroresExiste" class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col">ID FALLA</th>
					<th scope="col">ID OBSERVACIÓN</th>
					<th scope="col">TIPO FALLA</th>
					<th scope="col">COMENTARIO</th>
					<th scope="col">SUPERVISOR</th>
					<th scope="col">INDICACIÓN</th>
					<th scope="col">OBSERVACIÓN</th>
					<th scope="col" style="width: 17%">--</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="container-fluid" id="formularioModificacion" style="display: none; height: 600px;">
	<div class="row flex-row h-100">
		<div class="col-6 vh-100 offset-3 pt-lg-5">
			<div class="card">
				<div class="card-header">
					<div class="card-title text-center">
						<label>MODIFICACIÓN DE FALLA: <label><label id="idFalla"></label>
					</div>
					<div class="card-body">
						<div class="row flex-row">
							TIPO FALLA: 
						</div>
						<div class="row flex-row">
							<select class="form-control" id="tipoFallaM" value="placeholder">
								<option>--falla--</option>
							</select>
						</div>
						<div class="row flex-row">
							COMENTARIO: <input type="text" class="form-control" id="comentarioM">
						</div>
						<div class="row flex-row">
							SUPERVISOR QUE INDICA:
						</div>
						<div class="row flex-row">
							<select class="form-control" id="supervisorM" value="placeholder">
								<option>--Supervisor--</option>
							</select>
						</div>
						<div class="row flex-row">
							INDICACIÓN:
						</div>
						<div class="row flex-row">
							<select class="form-control" id="indicacionM" value="placeholder">
								<option>--Indicacion--</option>
							</select>
						</div>
						<div class="row flex-row">
							OBSERVACIÓN: <input type="text" class="form-control" id="observacionM">
						</div>
						<div class="row pt-4">
							<button class="btn btn-primary mb-2 btn-block h-100" id="guardarModificacion">GUARDAR</button>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> --}}

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="nr">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Numero de registro</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						
					</div>
					<div class="row">
						<div class="col-6 ml-auto">
							<input type="text" id="nRegistro" class="form-control">
						</div>
						<div class="col-3 ml-auto">
							<button class="btn btn-primary btn-block" id="btnCopiar">Copiar</button>
						</div>
						<div class="col-3 ml-auto">
							<button class="btn btn-primary btn-block" id="btnModificar">Modificar</button>
						</div>
					</div>
					<div class="row">Pieza:</div>
					<div class="flex-row">
						<select class="form-control" id="individual" class="dropdown"></select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
				<button type="button" class="btn btn-primary" id="btnNR">Guardar</button>
			</div>
		</div>
	</div>
</div>
@endsection
@endif
@section('scripts')
{!! Html::script('js\cyp.js') !!}
@endsection