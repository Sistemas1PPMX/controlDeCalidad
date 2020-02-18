@extends('layouts.dump')
@if(Session::has('id'))
@section('navbar')
<div class="col-2 text-center p-0 align-bottom">
	<label class="text-center p-0 align-bottom align-text-bottom" style="font-family: 'Roboto', sans-serif; color: white;"><h2 id="usuario"></h2></label>
</div>
@endsection
@section('content')
<div class="flex-row">
	<label id="inspector" hidden="true">{{Session::get('id')}}</label>
</div>

<div class="container-fluid" id="preRevision">
	<div class="row m-4" id="selectores">
		<div class="col-4">
			<div class="row ">
				PROYECTO:
			</div>
			<div class="row ">
				{!! Form::select('contract',$contract,null,['id'=>'proyecto'])!!}
			</div>
		</div>
		<div class="col-4">
			<div class="row ">
				PIEZA: 	
			</div>
			<div class="row ">
				{!! Form::select('ContractItem',['placeholder'=>'--Pieza--'],null,['id'=>'pieza'])!!}
				{{-- <input type="text" class="form-control" id="piezaInput" readonly="readonly"> --}}
			</div>
		</div>
		<div class="col-2">
			PIEZA INDIVIDUAL:
			<select id="piezaArmado" class="dropdown">
				<option value="placeholder">--Seleccione Pieza--</option>
			</select>
			
			{{-- {!! Form::select('piezaArmado',['placeholder'=>'--Pieza--'],null,['id'=>'piezaArmado'])!!} --}}
			
			{{-- ÁREA: <label id="area">Armado</label> --}}
		</div>
		<div class="col-2">
			<label>REVISION: </label>
			<input type="text" id="nRevision" class="form-control">
		</div>	
	</div>
	<div class="row  m-4" id="informacion2">
		<div class="col-4">
			<div class="row  mr-4">
				REVISADAS: <input type="number" class=" form-control" id="revisadas" readonly="true">	
			</div>
		</div>
		<div class="col-4">
			<div class="row  mr-4">				
				ACEPTADAS: <input type="number float-right" class="form-control" id="aceptadas" readonly="true">
			</div>
		</div>
		<div class="col-4">
			<div class="row  mr-4">				
				PIEZAS RECHAZADAS: <input type="number" class="form-control" id="piezasRechazadas" readonly="true">	
			</div>
		</div>
	</div>
	<div class="row  m-4" id="informacion1">
		<div class="col-4">
			{{-- PIEZAS RESTANTES: <input type="number" class="form-control" id="piezasRestantes" readonly="true">				 --}}
		</div>
		<div class="col-4 ">			
			STATUS:
			<div class=" h-100 float">
				<input type="text" class="form-control" id="status" value="PENDIENTE" readonly="true">
			</div>
		</div>
		<div class="col-4">
			NÚMERO DE OBSERVACIÓN
			<select id="piezaOB" class="dropdown">
				<option value="placeholder">--con OB--</option>
			</select>
		</div>
	</div>
</div>


<div class="row m-4" id="botonesInfo">
	<div class="col-2">
		<button class="btn btn-primary btn-block" id="btnNuevaRevisionParcial">REGISTRO PARCIAL</button>
	</div>
	<div class="col-2">
		<button class="btn btn-primary btn-block" id="btnNuevaRevision">REGISTRO FINAL</button>
	</div>
	<div class="col-4"></div>
	<div class="col-2 p-0">
		<button class="btn btn-danger btn-block mr-4" id="refabricacion">Refabricacion</button>
	</div>
</div>

<div class="flex-row" id="infoTabla">
	<table id="info" class="table table-bordered">
		<thead class="thead-dark">
			<tr>
				<th scope="col">FECHA</th>
				<th scope="col">INSPECTOR</th>
				<th scope="col">REVISION</th>
				<th scope="col">EVENTO</th>
				<th scope="col">COMENTARIO REVISION</th>
				<th scope="col">NUMERO OB</th>
				<th scope="col">ESTADO DE INSPECCION</th>
				<th scope="col">INDICACION</th>
				<th scope="col">OBSERVACIONES</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

{{-- Formulario de revision --}}
<div class="container-fluid" id="revision"> 
	<div class="row" id="infoRevision">
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
			<button class="btn btn-success btn-block" style="height: 100%" id="btnAceptarParcial">ACEPTAR PARCIAL</button>
		</div>
		<div class="col-3">
			<button class="btn btn-warning btn-block" style="height: 100%" id="btnRegresarRevision">REGRESAR</button>
		</div>
	</div>
	<div class="row w-100 mt-3 ml-3">
		<div class="col-6">
			<label>COMENTARIO APROBACION: </label>
			<input type="text" id="comentarioParcial" class="form-control">
		</div>
		<div class="col-6">
			<label>NOMBRE DEL ARMADOR: </label>
			<select class="selectpicker" id="nombreArmador" multiple>
				<option value="placeholder">--Seleccione--</option>
			</select>
			
		</div>
	</div>
</div>	

<div class="container-fluid mt-3" id="formObservacion">
	<span>
		<div class="flex-row">
			<label>FORMULARIO DE FALLA</label>
			<label class="offset-5">PIEZA ACTUAL:</label>
			<label id="piezaActual"></label>
		</div>
		<div class="row">
			<div class="col-4">
				<div class="flex-row">
					DEFECTO: 	
				</div>
				<div class="flex-row">
					{!! Form::select('defecto',['placeholder'=>'--Seleccione--'],null,['id' => 'defecto']) !!}
				</div>
			</div>
			<div class="col-4">
				DESCRIPCION:
				<input type="text" id="descripcion" class="form-control">
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
		<div class="row">
			<div class="col-4">
				<div class="flex-row">
					SUPERVISOR QUE INDICA:
				</div>
				<div class="flex-row">
					<select class="form-control" id="supervisor" value="placeholder">
						<option>--Supervisor--</option>
					</select>
				</div>
				{{-- {!! Form::select('supervisor',['placeholder'=>''],null,['id'=>'supervisor'])!!} --}}
			</div>
			<div class="col-4">
				<div class="flex-row">
					INDICACIÓN:						
				</div>
				<div class="flex-row">
					<select class="form-control" id="indicacion" value="placeholder">
						<option>--Indicacion--</option>
					</select>

				</div>
				{{-- {!! Form::select('indicacion',['placeholder'=>''],null,['id'=>'indicacion'])!!} --}}
			</div>
			<div class="col-4">
				OBSERVACIONES: <input type="text" id="observaciones" class="form-control">
			</div>
		</div>
		<div class="row m-4">
			<div class="col-3 offset-md-2">
				<button class="btn btn-secondary btn-block" style="height: 100%" id="btnAnadirFalla">AÑADIR FALLA</button>
			</div>
			<div class="col-3 offset-md-2">
				<button class="btn btn-primary btn-block" style="height: 100%" id="btnGuardarObservacion">GUARDAR OBSERVACIÓN</button>
			</div>
		</div>
	</span>
</div>


<div class="flex-row" id="tabla">
	<table id="errores" class="table table-bordered">
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

<div class="container-fluid" id="tablaErrores">
	<div class="row ml-4 mr-4">
		<div class="col-4">
			<button class="btn btn-primary h-100 btn-block" id="rerevision">RE-REVISIÓN</button>
		</div>
		<div class="col-3">
			<button class="btn btn-success btn-block h-100 rerevision" id="btnIgual">FINALIZAR SIN MODIFICACION</button>
		</div>
		<div class="col-3">
			<button class="btn btn-success btn-block h-100 rerevision" id="btnEliminaFalla">LIBERAR FALLAS SELECCIONADAS</button>
		</div>
		<div class="col-2">
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

<div class="container-fluid" id="formularioModificacion" >
	<div class="h-100">
		<div class="col-6 vh-100 offset-3">
			<div class="card">
				<div class="card-header">
					<div class="card-title text-center">
						<label>MODIFICACIÓN DE FALLA: </label><label id="idFalla"></label>

					</div>
					<div class="card-body">
						<div class="row">
							TIPO FALLA: 
						</div>
						<div class="row">
							<select class="form-control" id="tipoFallaM" value="placeholder">
								<option>--falla--</option>
							</select>
						</div>
						<div class="row">
							COMENTARIO: <input type="text" class="form-control" id="comentarioM">
						</div>
						<div class="row">
							SUPERVISOR QUE INDICA:
						</div>
						<div class="row">
							<select class="form-control" id="supervisorM" value="placeholder">
								<option>--Supervisor--</option>
							</select>
						</div>
						<div class="row">
							INDICACIÓN:
						</div>
						<div class="row">
							<select class="form-control" id="indicacionM" value="placeholder">
								<option>--Indicacion--</option>
							</select>
						</div>
						<div class="row">
							OBSERVACIÓN: <input type="text" class="form-control" id="observacionM">
						</div>
						<div class="row">
							<button class="btn btn-primary mb-2 btn-block h-100" id="guardarModificacion">GUARDAR</button>	
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

@endsection
@endif
@section('scripts')
{!! Html::script('js\armado2.js') !!}
@endsection