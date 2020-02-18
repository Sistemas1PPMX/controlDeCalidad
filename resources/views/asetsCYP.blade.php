@extends('layouts.dump')
@if(Session::has('id'))
@section('navbar')
<div class="col-2">
	<h5 id="usuario" class="text-white"></h5>
</div>
@endsection()			
@section('content')
<div class="flex-row">
	<label id="inspector" hidden="true">{{Session::get('id')}}</label>
</div>
<div style="height:100%; width: 100%;" id="preRevision">	
	<div class="flex-row d-flex mt-4" style="width: 100%; height: 10%;" id="selectores">
		<div class="col-4" style=" height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%">
				<H3>PROYECTO:</H3>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%">
				{!! Form::select('contract',$contract,null,['id'=>'proyecto'])!!}
			</div>
		</div>
		<div class="col-4" style=" height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%">
				<H3>PIEZA:</H3> 	
			</div>
			<div class="flex-row" style="height: 50%; width: 100%">
				{!! Form::select('ContractItem',['placeholder'=>'--Pieza--'],null,['id'=>'pieza'])!!}
			</div>
		</div>
		<div class="col-2" style=" height: 100%">
			<H3>ÁREA:</H3><label id="area">Corte y perforado</label>
		</div>
		<div class="col-2 p-0" style=" height: 100%">
			<button class="btn btn-block btn-danger h-100 w-100" id="pintura">PARA PINTURA</button>
		</div>
	</div>
	<div class="flex-row d-flex mt-4" style="width: 100%; height: 12%;" id="informacion1">
		<div class="col-3" style=" height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%">
				<H3>CANTIDAD:</H3>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%">
				<input type="number" class="form-control" id="cantidad" class="quantity" readonly="true">	
			</div>
		</div>
		<div class="col-3" style=" height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%">
				<h4>
					PIEZAS RESTANTES:
				</h4>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%">
				<input type="number" class="form-control" id="piezasRestantes" readonly="true">				
			</div>
		</div>
		<div class="col-3" style=" height: 100%">			
			<div class="flex-row" style="height: 50%; width: 100%">
				<h5>
					PORCENTAJE DE APROBACIÓN:
				</h5>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%">
				<div class="flex-row d-flex">
					<input type="number" class="form-control" id="muestra" value="10" style="width: 80%">%
				</div>
			</div>
		</div>
		<div class="col-3" style="height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%;">
				<h3>
					LOTE:
				</h3>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%;">
				<input type="number" class="form-control" id="lote">	
			</div>
		</div>
	</div>
	<div class="flex-row d-flex" style="width: 100%; height: 10%;" id="informacion2">
		<div class="col-3" style="height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%;">
				<h3>REVISADAS:</h3>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%;">
				<input type="number" class=" form-control" id="revisadas" readonly="true">	
			</div>
		</div>
		<div class="col-3" style="height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%;">
				<h4>PIEZAS RECHAZADAS:</h4>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%;">
				<input type="number" class="form-control" id="piezasRechazadas" readonly="true">	
			</div>
		</div>
		<div class="col-3" style="height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%;">
				<h3>ACEPTADAS:</h3>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%;">
				<input type="number float-right" class="form-control" id="aceptadas" readonly="true">
			</div>
		</div>
		<div class="col-3" style="height: 100%">
			<div class="flex-row" style="height: 50%; width: 100%;">
				<h5>NÚMERO DE OBSERVACIÓN:</h5>
			</div>
			<div class="flex-row" style="height: 50%; width: 100%;">
				<select id="piezaOB" class="dropdown">
					<option value="placeholder">--con OB--</option>
				</select>
			</div>
		</div>
	</div>
	<div class="flex-row" id="botonesInfo" style="height:5%">
		<div class="col-4" style="height: 100%">
			<button class="btn btn-primary btn-block" id="btnNuevaRevision" style="height: 100%">REGISTRO</button>
		</div>
	</div>
</div>
<div style="height:100%; width: 100%" id="revision" style="display: none;">
	<div class="flex-row mt-5 d-flex" id="infoRevision" style="height: 12%">
		<div class="col-6">
			<div class="row">
				<div class="col-4">
					APROBADAS: <input type="number" class="form-control soloNumeros" id="piezasAprobadas">
				</div>
				<div class="col-4">
					MUESTRA: <input type="number" class="form-control" id="paraAprobar" readonly="true">	
				</div>
				<div class="col-4">
					REVISION: <input type="number" class="form-control" id="revisionPlano">	
				</div>
			</div>
			<div class="flex-row">
				COMENTARIO: <input type="text" id="comentario" class="form-control">
			</div>
		</div>
		<div class="col-2" style="height: 100%" style="height: 12%">
			<div style="height: 25%">
			</div>
			<div style="height: 50%">
				<button class="btn btn-danger btn-block" style="height: 100%; white-space: normal ! important; word-wrap: break-word ! important; height: 100%" id="btnObservacion">OBSERVACION</button>
			</div>
			<div style="height: 25%">
			</div>
		</div>
		<div class="col-2" style="height: 100%" style="height: 12%;">
			<div style="height: 25%">
			</div>
			<div style="height: 50%">
				<button class="btn btn-success btn-block" style="height: 100%; white-space: normal ! important; word-wrap: break-word ! important; height: 100%" id="btnAceptar">ACEPTAR PIEZA</button>
			</div>
			<div style="height: 25%">
			</div>
			{{-- <button class="btn btn-success btn-block" style="height: 100%; visibility: hidden;" id="btnGuardar">Guardar Revision</button> --}}
		</div>
		<div class="col-2" style="height: 100%" style="height: 12%">
			<div style="height: 25%">
			</div>
			<div style="height: 50%">
				<button class="btn btn-warning btn-block" style="height: 100%; white-space: normal ! important; word-wrap: break-word ! important; height: 100%" id="btnRegresarRevision">REGRESAR</button>
			</div>
			<div style="height: 25%">
			</div>
		</div>
	</div>
	<div class="flex-row mt-3" id="formObservacion" style="visibility: hidden;height: 25%;">
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
		<div class="row" style="height: 60px;">
			<div class="col-3 offset-md-2" style="height: 100%">
				<button class="btn btn-secondary btn-block" style="height: 100%; white-space: normal ! important; word-wrap: break-word ! important; height: 100%" id="btnAnadirFalla">AÑADIR FALLA</button>
			</div>
			<div class="col-3 offset-md-2" style="height: 100%">
				<button class="btn btn-primary btn-block" style="height: 100%; white-space: normal ! important; word-wrap: break-word ! important; height: 100%" id="btnGuardarObservacion">GUARDAR OBSERVACIÓN</button>
			</div>
		</div>
	</div>
	<div class="flex-row mt-5" id="tabla" style="width: 100%">
		<table id="errores" class="table table-bordered" style="visibility: hidden; width: 100%">
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

<div class="flex-row mt-5" id="tablaErrores" style="display: none; height: 100%;">
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

{{-- <div class="container-fluid" id="formularioModificacion" style="display: none; height: 600px;">
	<div class="flex-row h-100">
		<div class="col-6 vh-100 offset-3 pt-lg-5">
			<div class="card">
				<div class="card-header">
					<div class="card-title text-center">
						<label>MODIFICACIÓN DE FALLA: <label><label id="idFalla"></label>
					</div>
					<div class="card-body">
						<div class="flex-row">
							TIPO FALLA: 
						</div>
						<div class="flex-row">
							<select class="form-control" id="tipoFallaM" value="placeholder">
								<option>--falla--</option>
							</select>
						</div>
						<div class="flex-row">
							COMENTARIO: <input type="text" class="form-control" id="comentarioM">
						</div>
						<div class="flex-row">
							SUPERVISOR QUE INDICA:
						</div>
						<div class="flex-row">
							<select class="form-control" id="supervisorM" value="placeholder">
								<option>--Supervisor--</option>
							</select>
						</div>
						<div class="flex-row">
							INDICACIÓN:
						</div>
						<div class="flex-row">
							<select class="form-control" id="indicacionM" value="placeholder">
								<option>--Indicacion--</option>
							</select>
						</div>
						<div class="flex-row">
							OBSERVACIÓN: <input type="text" class="form-control" id="observacionM">
						</div>
						<div class="flex-row pt-4">
							<button class="btn btn-primary mb-2 btn-block h-100" id="guardarModificacion">GUARDAR</button>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> --}}

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="formularioModificacion">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Numero de registro</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid p-0" style=" height: 600px;">
					<div class="flex-row h-100">
						<div class="col-12 pt-lg-5">
							<div class="card">
								<div class="card-header">
									<div class="card-title text-center">
										<label>MODIFICACIÓN DE FALLA: <label><label id="idFalla"></label>
									</div>
									<div class="card-body">
										<div class="flex-row">
											TIPO FALLA: 
										</div>
										<div class="flex-row">
											<select class="form-control" id="tipoFallaM" value="placeholder">
												<option>--falla--</option>
											</select>
										</div>
										<div class="flex-row">
											COMENTARIO: <input type="text" class="form-control" id="comentarioM">
										</div>
										<div class="flex-row">
											SUPERVISOR QUE INDICA:
										</div>
										<div class="flex-row">
											<select class="form-control" id="supervisorM" value="placeholder">
												<option>--Supervisor--</option>
											</select>
										</div>
										<div class="flex-row">
											INDICACIÓN:
										</div>
										<div class="flex-row">
											<select class="form-control" id="indicacionM" value="placeholder">
												<option>--Indicacion--</option>
											</select>
										</div>
										<div class="flex-row">
											OBSERVACIÓN: <input type="text" class="form-control" id="observacionM">
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="flex-row pt-4">
					<button class="btn btn-primary mb-2 btn-block h-100" id="guardarModificacion">GUARDAR</button>	
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="nr">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Numero de recepción</h5>
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