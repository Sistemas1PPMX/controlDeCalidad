
			<div class="col-3">
				
			</div>
			<div class="col-3">
				<div class="row flex-row">
						
				</div>
			</div>
			
			
			
			<div class="col-3" >
				<div class="col-3">
					
			</div>
			</div>
			
		</div>

		<div class="row flex-row m-3">
			
			
			<button class="btn btn-danger" style="display: none" id="btnEliminaFalla">EliminarFalla</button>
			{!! Form::select('revisada',['placeholder'=>'--con OB--'], null, ['id' => 'piezaOB'],['style' => 'width: 100%;']) !!}

			<button class="btn btn-danger" id="btnNuevaRevision">Observacion</button>
			<button class="btn btn-warning" id="btnCancelar">Cancelar</button>





		<div>
			defecto: {!! Form::select('defecto',['placeholder'=>'--Seleccione--'],null,['id' => 'defecto']) !!}
		</div>
		<div>
			descripcion: 
			<textarea id="descripcion"></textarea>
		</div>
		<div>
			
		</div>
		<div>
			Supervisor que indica: <input type="text" id="supervisorQI">
		</div>
		<div>
			observaciones <input type="text" id="observaciones">
		</div>
		<div>
			<button class="btn btn-primary" id="btnError">agregar error</button>
			<button class="btn btn-primary" id="btnElimina">Eliminar error</button>
			<button class="btn btn-primary" id="btnGuardarOb">Guardar observacion</button>
		</div>
		<div class="row" id="tabla">
			<table id="errores" class="table table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col">--</th>
						<th scope="col">Proyecto</th>
						<th scope="col">Pieza</th>
						<th scope="col">Lote</th>
						<th scope="col">Defecto</th>
						<th scope="col">Descripcion</th>
						<th scope="col">Area</th>
						<th scope="col">Supervisor</th>
						<th scope="col">Observaciones</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="row" id="tablaErrores" style="display: none;">
		<table id="erroresExiste" class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col">--</th>
					<th scope="col">ID FALLA</th>
					<th scope="col">ID OBSERVACION</th>
					<th scope="col">TIPO FALLA</th>
					<th scope="col">COMENTARIO</th>
					<th scope="col">OBSERVACIONES</th>
					<th scope="col">STATUS</th>
				</tr>
			</thead>
		</table>
	</div>