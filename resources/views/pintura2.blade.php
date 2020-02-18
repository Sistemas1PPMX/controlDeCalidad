@extends('layouts.dump')
@if(Session::has('id'))
@section('navbar')
<div class="col-2 text-center p-0 align-bottom">
	<label class="text-center p-0 align-bottom align-text-bottom" style="font-family: 'Roboto', sans-serif; color: white;"><h2 id="usuario"></h2></label>
	<label id="supervisor" style="display: none;">{{Session::get('id')}}</label>
</div>
@endsection
@section('content')
<div class="container-fluid" style="width: 100%;">
	<div class="row my-2">
		<div class="col-4">
			<select class="form-control" id="lote">
				<option value="placeholder">--placeholder--</option>
			</select>
		</div>
		<div class="col-4">
			<select class="form-control" id="etapa">
				<option value="pinturaPrep">Preparacion</option>
				<option value="pinturaC1">Capa 1</option>
				<option value="pinturaC2">Capa 2</option>
				<option value="pinturaC3">Capa 3</option>
			</select>
		</div>
		<div class="col-4">
			<button class="btn btn-primary btn-block">Cerrar lote</button>
		</div>
	</div>
	<div class="row mt-2">
		<table class="table table-bordered my-2" id="tabla">
			<thead class="thead-dark">
				<tr>
					<th>Pieza</th>
					<th>Cantidad</th>
					<th>Status</th>
					<th><input type="button" class="btn btn-success btn-block" value="Aceptar general" id="aceptarG"></th>
					<th><input type="button" class="btn btn-danger btn-block" value="Observacion general" id="observacionG"></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modalObservacion">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Observacion</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						Reemplazar muestra:
						<select class="form-control" id="muestra"></select>
					</div>
					<div class="row">
						<div class="col-6">
							Lote:
							<label id="lblLote"></label>
						</div>
						<div class="col-6">
							Pieza:
							<label id="lblPieza"></label>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							Defecto:
							<select id="defecto" class="form-control">
								
							</select>
						</div>
						<div class="col-4">
							Descripcion:
							<input type="text" id="descripcion" class="form-control">
						</div>
						<div class="col-4">
							Supervisor QI:
							<select class="form-control" id="sqi">
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							Indicacion:
							<select class="form-control" id="indicacion">
							</select>
						</div>
						<div class="col-4">
							Observaciones:
							<input type="text" id="observaciones" class="form-control">
						</div>
						<div class="col-4">
							<button class="btn btn-primary btn-block" id="btnOb">Añadir Ob</button>
						</div>
					</div>
					<div class="row" style="height: 20px;"></div>
					<table class="table table-bordered" id="tablaOb">
						<thead class="thead-dark">
							<tr>
								<th>Defecto</th>
								<th>Descripcion</th>
								<th>Supervidor</th>
								<th>Indicacion</th>
								<th>Observacion</th>
								<th>--</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				{{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
				<button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
			</div>
		</div>
	</div>
</div>
@endsection
@endif
@section('scripts')
{!! Html::script('js\pintura.js') !!}
{!! Html::script('js\bootstrap-datepicker.js') !!}
@endsection