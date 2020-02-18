var inspector;
var revision;
var pieza;
var idPiezaOB;
var consecutivo;
var idObservacion;
var cantidadPiezaConOB;
var cantidadFallas;
var rechazadas;
var paraAprobar;
var aprobadas;
var revisadas;
var status;
var lote;
var idEtapa = 4;
var nPieza =1;
var piezaSeleccionada;
var contadorA = 0;
var contadorRev = 0;
var contadorRech = 0;

$(document).ready(function() {
	$('select').selectpicker();
	$('select').selectpicker('render');

	$.get("regresaInspector/"+$("#inspector").text()+"", function(response, state){
		$("#usuario").append(response[0].nombreUsuario);
		inspector = $("#inspector").text();

	});

	$.get("regresaSupervisores", function(response, state){
		$('#supervisor').empty();
		$('#supervisorM').empty();
		for(var i = 0; i<response.length; i++){
			$("#supervisor").append("<option value='"+response[i].idSupervisor+"'>"+response[i].nombreSupervisor+" "+response[i].apellidoPsupervisor+" "+response[i].apellidoMsupervisor+"</option>");
			$("#supervisorM").append("<option value='"+response[i].idSupervisor+"'>"+response[i].nombreSupervisor+" "+response[i].apellidoPsupervisor+" "+response[i].apellidoMsupervisor+"</option>");
			$("#supervisor").selectpicker('reload');
			$("#supervisorM").selectpicker('reload');
			$("#supervisor").selectpicker('refresh');
			$("#supervisorM").selectpicker('refresh');
		}
	});

	$('#indicacion').empty();
	$('#indicacionM').empty();
	$("#indicacion").append("<option value='Reprocesar'>Reprocesar</option>");
	$("#indicacion").append("<option value='Reparar'>Reparar</option>");
	$("#indicacion").append("<option value='Usar como está'>Usar como está</option>");
	$("#indicacion").append("<option value='Scrap'>Scrap</option>");
	$("#indicacionM").append("<option value='Reprocesar'>Reprocesar</option>");
	$("#indicacionM").append("<option value='Reparar'>Reparar</option>");
	$("#indicacionM").append("<option value='Usar como está'>Usar como está</option>");
	$("#indicacionM").append("<option value='Scrap'>Scrap</option>");
	$('#indicacion').selectpicker('reload');
	$('#indicacionM').selectpicker('reload');
	$('#indicacion').selectpicker('refresh');
	$('#indicacionM').selectpicker('refresh');

	$.get("defectos", function(response){
		$("#defecto").empty();
		for(i = 0; i < response.length; i++){
			$("#defecto").append("<option value='"+response[i].idTipoFalla+"'> "+response[i].descripcionTipoFalla+"</option>");
			$("#tipoFallaM").append("<option value='"+response[i].idTipoFalla+"'> "+response[i].descripcionTipoFalla+"</option>");
		}
		$("#defecto").selectpicker('reload');
		$("#tipoFallaM").selectpicker('reload');
		$("#defecto").selectpicker('refresh');
		$("#tipoFallaM").selectpicker('refresh');
	});

	$(document).on("wheel", "input[type=number]", function (e) {
		$(this).blur();
	});
	
	$(":input[type=number]").on('keypress', function(e){
		var keyCode = (event.keyCode ? event.keyCode : event.which);
		if(keyCode == '13'){
			document.blur();
		}
	});
	
	$(":input[type=number]").on('keypress', function(e){
		return e.metaKey || // cmd/ctrl
		e.which <= 0 || // arrow keys
		e.which == 8 || // delete key
		/[0-9]/.test(String.fromCharCode(e.which)); // numbers
	});
	
	revision = 0;
	pieza = 0;
	idPiezaOB = 0;
	consecutivo = 0;
	idObservacion= 0;
	cantidadPiezaConOB= 0;
	cantidadFallas= 0;
	rechazadas= 0;
	paraAprobar= 0;
	aprobadas= 0;
	revisadas= 0;
	status= 0;
	idEtapa = 4;
	
	$("#cantidad").val(0);
	$("#revisadas").val(0);
	$("#piezasRechazadas").val(0);
	$("#lote").val(0);
	$("#aRevisar").val(0);
	$("#piezasAprobadas").val(0);
	$("#piezasRestantes").val(0);
	$("#aceptadas").val(0);
	$("#revision").hide()
	$("#revision").hide();
	$("#tablaErrores").hide();
	$("#btnEliminaFalla").hide();
	$("#lote").attr('readonly',false);
	$("#piezaActual").text(nPieza);
	
	$("input[type=number]").on("focus", function() {
		$(this).on("keydown", function(event) {
			if (event.keyCode === 38 || event.keyCode === 40) {
				event.preventDefault();
			}
		});
	});

	$.get("piezaStrumis/"+$("#proyecto").val()+"",function(response, state){
		$("#pieza").empty();
		for(i = 0; i < response.length; i++){
			$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].cod_elemento+"</option>");
		}
		reset();
		$('#pieza').selectpicker('refresh');
	});

	piezaSeleccionada = $("#pieza").val();
	$("#lote").val(0);
	$("#paraAprobar").val(0);
});

$("#pintura").click(function(event){
	paraPintura();
});

$("#proyecto").on('changed.bs.select',function(event){
	$("#tablaErrores").hide();
	$("#revision").hide();
	$("#informacion1").show();
	$("#informacion2").show();
	$("#preRevisar").show();
	$("#botonesInfo").show();
	$.get("piezaStrumis/"+event.target.value+"",function(response, state){
		$("#pieza").empty();
		for(i = 0; i < response.length; i++){
			$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].cod_elemento+"</option>");
		}
		$('#pieza').selectpicker('refresh');
	});
	reset();
	if ($('#pintura').text() == 'PARA PINTURA') {	
	}else{
		paraPintura();
	}
});

$("#pieza").on('changed.bs.select',function(event){
	console.log($("#pieza").selectpicker('val'));
	if (parseInt(revision) != 0) {
		var selection = confirm("Al cambiar de pieza el lote y la revision actual se cerraran! ¿Continuar?")
		if (selection) {
			$("#tablaErrores").hide();
			$("#revision").hide();
			$("#informacion1").show();
			$("#informacion2").show();
			$("#preRevisar").show();
			$("#botonesInfo").show();
			piezaSeleccionada = $("#pieza").selectpicker('val');
			reset();
			actualizaCantidad();
		}else{
			$("#pieza").blur();
		}	
	}else{
		$("#tablaErrores").hide();
		$("#revision").hide();
		$("#informacion1").show();
		$("#informacion2").show();
		$("#preRevisar").show();
		$("#botonesInfo").show();
		piezaSeleccionada = $("#pieza").selectpicker('val');
		actualizaCantidad();
	}
});

$("#btnObservacion").click(function(event){
	if (anadirRevision()) {
		$("#formObservacion").css('visibility','visible');
		/*$("#btnAceptar").css('visibility','hidden');*/
		$("#btnGuardar").css('visibility','visible');
		$("#errores").css('visibility','visible');
	}
});

$("#btnAceptar").click(function(event){
	if (anadirRevision()) {
		$("#piezasAprobadas").val(parseInt($("#piezasAprobadas").val())+parseInt(1));
		$("#formObservacion").css('visibility','hidden');
		$("#errores").css('visibility','hidden');
		validaAprobacion();
	}
});

$("#pieza").on('select2:close',function(event){
	$("#tablaErrores").hide();
	$("#revision").hide();
	$("#informacion1").show();
	$("#informacion2").show();
	$("#preRevisar").show();
	$("#botonesInfo").show();
	actualizaCantidad();
	piezaSeleccionada = $("#pieza").selectpicker('val');
});


$("#lote").click(function(event){
	if ($(this).is('[readonly]')) {
	}else{
		$(this).val("");
		$(this).blur(function(event){
			if ($(this).val() == "") {
				$(this).val(0);
			}
		});
	}
});

$("#piezasAprobadas").click(function(event){
	$(this).val("");
	$(this).blur(function(event){
		if ($(this).val() == "") {
			$(this).val(0);
		}
	});
});

$("#btnRegresarRevision").click(function(event) {
	regresar();
});

$("#btnRegresarFallas").click(function(event) {
	regresar();
});

$("#lote").change(function(event){
	if ($("#cantidad").val() != null) {
		if (parseInt($("#cantidad").val()) >= parseInt($("#lote").val())) {
			if (parseInt($("#lote").val())<=parseInt($("#piezasRestantes").val())) {
				if (event.target.value <= 0) {
					alert("El lote no puede ser 0 o un valor negativo")
				}else{
					$.get("validaLote/"+$("#lote").val()+"/cantidad/"+$("#cantidad").val()+"/muestra/"+$('#muestra').val()+"",function(response,state){
						paraAprobar = parseInt(response);
						$("#paraAprobar").val(response);
					});
					lote = $("#lote").val();
				}
			}else{
				alert("El lote no puede ser mayor a las piezas restantes");
				$("#lote").val(0);
			}
		}else{
			$("#lote").val(0);
			alert("El lote no puede ser mayor a la cantidad de piezas a fabricar");
		}
	}else{
		$("#lote").val(0);
		alert("No se ha seleccionado pieza");
	}
});

$("#btnNuevaRevision").click(function(event){
	lote = $("#lote").val();
	$("#piezaActual").text(nPieza);
	if(lote > 0){
		$("#preRevision").hide();
		$("#revision").show();
		if (revision == 0) {
			$.get("crearRevision/"+$("#proyecto").val()+"/pieza/"+$("#pieza").selectpicker('val')+"/inspector/"+inspector+"/etapa/"+idEtapa+"/nombreP/"+$("#pieza option:selected").text()+"", function(response, state){
				revision = response;
				console.log(response);
			});
		}	
	}else{
		alert("Aun no se selecciona lote");
	}
});

$("#errores").on('click', 'input[type="button"]', function(e){
	$(this).closest('tr').remove()
})

$("#btnAnadirFalla").click(function(event){
	var table = document.getElementById("errores");
	var proyecto = $('#proyecto').val();
	var pieza = $("#pieza").selectpicker('val');
	var lote = $('#lote').val();
	var defecto = $('#defecto option:selected').text();
	var descripcion = $('#descripcion').val();
	var supervisor = $('#supervisor option:selected').text();
	var observaciones = $('#observaciones').val();
	var indicacion = $('#indicacion').val();
	if ($("#descripcion").val() != "" && $("#observaciones").val() != "" && $("#supervisor").val() != "placeholder") {
		var markup = "<tr><td>"+proyecto+"</td><td>"+pieza+"</td><td>"+lote+"</td><td>"+defecto.toUpperCase()+"</td><td>"+descripcion.toUpperCase()+"</td><td>"+'Corte y perforado'.toUpperCase()+"</td><td>"+supervisor.toUpperCase()+"</td><td>"+indicacion.toUpperCase()+"</td><td>"
		+observaciones.toUpperCase()+"</td><td><input type='button' name='record' class='btn btn-danger btn-block' value='Eliminar' style='height: 100%;'></td></tr>";
		$("#errores").append(markup);
		cantidadFallas++;
		$("#descripcion").val("");
		$("#observaciones").val("");
	}else{
		alert("las observaciones no pueden tener campos vacios");
	}
});

$("#btnElimina").click(function(event){
	$("#errores").find('input[name="record"]').each(function(){
		if($(this).is(":checked")){
			$(this).parents("tr").remove();
			cantidadFallas--;
		}
	});
});
//AQUI!
$("#btnGuardarObservacion").click(function(){
	$("#formObservacion").css('visibility','hidden');
	$("#btnAceptar").css('visibility','visible');
	$("#errores").css('visibility','hidden');	
	if (parseInt($("#errores tr").length) > 1) {
		$.get("crearPiezaOB/"+revision+"/consecutivo/"+consecutivo+"",function(response, state){
			consecutivo = consecutivo + 1;
			idPiezaOB = response;
			$.get("crearObservacion/"+idPiezaOB+"/inspector/"+inspector+"",function(response, state){
				idObservacion = response;
				$("#errores > tr").each(function(){
					valor = [];
					$(this).children().each(function(){
						valor.push($(this).text());
					});
					$.get("creaFalla/"+valor[6]+"/observacion/"+idObservacion+"/idTipoFalla/"+valor[3]+"/comentarioFalla/"+valor[4]+"/observaciones/"+valor[8]+"/indicacion/"+valor[7]+"", function(response, state){
						console.log(response);
						ddpiezasob($("#pieza").val());
					});
				});
				$("#errores tr:not(:first)").remove();
			});
		});
		contadorRech = contadorRech+1;
		contadorRev = contadorA + contadorRech;
		nPieza = nPieza+1;
		$("#piezaActual").text(nPieza);
		if (contadorRev < parseInt($("#lote").val())) {
			var muestra = parseInt($("#paraAprobar").val()) + 1
			$("#paraAprobar").val(muestra);
		}
		if (contadorRev == parseInt($("#lote").val())) {
			alert("se ha terminado de revisar este lote");
			reset();
		}
	}else{
		var respuesta = confirm("La pieza no contiene fallas, sera contabilizada como pieza aprobada");
		if (respuesta) {
			nPieza = nPieza+1;
			$("#piezaActual").text(nPieza);
			$("#piezasAprobadas").val(parseInt($("#piezasAprobadas").val())+parseInt(1));
		}
	}
});

//SE AÑADE EL INVIO DEL SUPERVISOR
$("#btnEliminaFalla").click(function(event){
	var valor = [];
	$("#erroresExiste").find('input[name="pendiente"]').each(function(){
		if($(this).val() == "En liberacion"){
			$(this).parents("tr").each(function(){
				$(this).find("td").each(function(){
					valor.push($(this).text());
				});
				$.get("eliminaFalla/"+valor[0]+"/inspector/"+inspector+"", function(response, state){
					$("#rerevision").css({
						'cursor': '',
						'pointer-events': '',
						'background-color': ''
					});
				});
				valor.length = 0;
			});
		}
	});
	$("#erroresExiste").find('input[name="pendiente"]').each(function(){
		if($(this).val() == "En liberacion"){
			$(this).parents("tr").remove();
		}
		actualizaCantidad();
		$("#tablaErrores").css('display', 'block');
	});
});

$("#piezaOB").on('hidden.bs.select',function(event){
	idObservacion = event.target.value;
	if ($("#piezaOB").val() != "placeholder") {
		$("#preRevision").hide();
		$("#informacion1").hide();
		$("#botonesInfo").hide();
		$("#informacion2").hide();
		$("#revision").hide();
		$("#tablaErrores").show();
		$("#btnEliminaFalla").show();
		$("#erroresExiste tr:not(:first)").remove();
		$.get("regresaFallas/"+event.target.value+"", function(response, state){
			for(i = 0; i<response.length;i++){
				var markup = "<tr><td>"+response[i].idFallas+"</td><td>"+response[i].idObservacion+"</td><td>"+response[i].descripcionTipoFalla+"</td><td>"+response[i].comentarioFalla+
				"</td><td>"+response[i].supervisorqi+"</td><td>"+response[i].indicacion+"</td><td>"+response[i].observaciones+"</td><td><input type='button' name='pendiente' class='btn btn-danger text-center rerevision' value='Pendiente' style='width: 50%; display: none;'><input type='button' name='modificar' class='btn btn-warning text-center rerevision' value='Modificar' style='width: 50%; display: none;'></td></tr>";	
				$("#erroresExiste").append(markup);
			}	
		});
	}
});

$("#rerevision").click(function(event){
	$("#rerevision").css({
		'cursor': 'not-allowed',
		'pointer-events': 'none',
		'background-color': 'grey'
	});
	$(".rerevision").css('display','inherit');
	$(".rerevision").css('visibility','visible');
	$.get('contadorRevision/'+$("#piezaOB").val()+"");
});

$("#erroresExiste").on('click', 'input[name="pendiente"]', function(e){
	if ($(this).closest('tr').find('input[name="pendiente"]').val() == "En liberacion") {
		$(this).closest('tr').find('input[name="pendiente"]').removeClass('btn-success');
		$(this).closest('tr').find('input[name="pendiente"]').addClass('btn-danger');
		$(this).closest('tr').find('input[name="pendiente"]').val("Pendiente");
	}else{
		$(this).closest('tr').find('input[name="pendiente"]').removeClass('btn-danger');
		$(this).closest('tr').find('input[name="pendiente"]').addClass('btn-success');
		$(this).closest('tr').find('input[name="pendiente"]').val("En liberacion");
	}
})

$("#erroresExiste").on('click', 'input[name="modificar"]', function(event){
	$('#btnEliminaFalla').prop("disabled",true);
	var idFalla = $(this).closest('tr').find('td:first').text();
	$.get("infoFalla/"+idFalla+"", function(response, state){
		$("#idFalla").text(idFalla);
		$('#tipoFallaM').find('option[value="'+response[0].idTipoFalla+'"]').attr('selected','selected');
		$("#comentarioM").val(response[0].ComentarioFalla);
		$('#supervisorM').find('option[value="'+response[0].supervisorqi+'"]').attr('selected','selected');
		$('#indicacionM').find('option[value="'+response[0].indicacion+'"]').attr('selected','selected');
		$("#observacionM").val(response[0].observaciones);
		$('#tipoFallaM').selectpicker('refresh');
		$('#supervisorM').selectpicker('refresh');
		$('#indicacionM').selectpicker('refresh');
		$("#formularioModificacion").modal();
	});
});

$("#guardarModificacion").click(function(event){
	$('#btnEliminaFalla').prop("disabled",false);
	$.get("modificaFalla/"+$("#idFalla").text()+"/tipoFalla/"+$("#tipoFallaM").val()+"/comentario/"+$("#comentarioM").val()+"/sqi/"+$("#supervisorM").val()+"/indicacion/"+$("#indicacionM").val()+"/observacion/"+$("#observacionM").val()+"", function(response,state){
		$("#erroresExiste tr:not(:first)").remove();
		$.get("regresaFallas/"+idObservacion+"", function(response, state){
			for(i = 0; i<response.length;i++){
				var markup = "<tr><td>"+response[i].idFallas+"</td><td>"+response[i].idObservacion+"</td><td>"+response[i].descripcionTipoFalla+"</td><td>"+response[i].comentarioFalla+
				"</td><td>"+response[i].supervisorqi+"</td><td>"+response[i].indicacion+"</td><td>"+response[i].observaciones+"</td><td><input type='button' name='pendiente' class='btn btn-danger text-center rerevision' value='Pendiente' style='width: 50%;'><input type='button' name='modificar' class='btn btn-warning text-center rerevision' value='Modificar' style='width: 50%;'></td></tr>";	
				$("#erroresExiste").append(markup);
				$("#formularioModificacion").modal('hide');
			}	
		});

	});
});

$("#piezasAprobadas").change(function(event){
	validaAprobacion();
});

$("#btnCancelar").click(function(event){
	reset();
});

$("#btnGuardar").click(function(event){
	var cantidadAprobadas = parseInt($("#lote").val())-parseInt(contadorRech);
	$.get("apruebaRevision/"+revision+"/cantidadAprobadas/"+cantidadAprobadas+"", function(response){
		alert("Se ha terminado de revisar: se aprobaron: "+cantidadAprobadas+" y tienen observaciones: "+contadorRech+"");
		actualizaCantidad();
		reset();
	});
});

$("#muestra").change(function(event) {
	if (parseInt($("#muestra").val())<=100) {
		actualizaAprobar();
	}else{
		alert("El porcentaje de muestra no puede exceder el 100%");
		$("#muestra").val(100);
		actualizaAprobar();
	}
});

function paraPintura(){
	if ($('#pintura').text() == 'PARA PINTURA') {	
		$('#pintura').removeClass("btn-danger");
		$('#pintura').text("MISCELANEOS");
		$('#pintura').addClass("btn-success");
		$.get('paraPintura/'+$("#proyecto").val()+'/', function(response, state){
			/*console.log(response);*/
			$('#pieza').empty();
			for(i=0;i<response.length;i++){
				$('#pieza').append("<option value='"+response[i].id+"'>"+response[i].cod_elemento+"</option>");
			}
			$('#pieza').selectpicker('reload');
			$('#pieza').selectpicker('refresh');
			actualizaCantidad();
		})
	}else{
		$('#pintura').removeClass("btn-success");
		$('#pintura').text("PARA PINTURA");
		$('#pintura').addClass("btn-danger");
		$.get("piezaStrumis/"+$("#proyecto").val()+"",function(response, state){
			$("#pieza").empty();
			for(i = 0; i < response.length; i++){
				$("#pieza").append("<option value='"+response[i].id+"'> "+response[i].cod_elemento+"</option>");
			}
			$('#pieza').selectpicker('refresh');
			actualizaCantidad();
		});
	}
}

/*$("#btnNR").click(function(event){
	$.get("apruebaRevision/"+revision+"/cantidadAprobadas/"+cantidadAprobadas+"", function(response){
		alert("Se ha terminado de revisar: se aprobaron: "+cantidadAprobadas+" y tienen observaciones: "+contadorRech+"");
		actualizaCantidad();
		reset();
	});

});*/

$("#individual").on('hidden.bs.select', function(event){
	$("#nRegistro").val($("#individual").selectpicker('val'));
});

$("#btnCopiar").click(function(event){
	$("#individual option").each(function(){
		$(this).val($("#nRegistro").val());
	});
})

$("#btnModificar").click(function(event){
	/*alert($("#individual").selectpicker('val'));*/
	$("#individual option:selected").val($("#nRegistro").val());
});

$("#btnNR").click(function(event){
	var cantidadAprobadas = parseInt($("#lote").val())-parseInt(contadorRech);
	$("#individual option").each(function(){
		$.get("registraNR/"+$("#pieza").val()+"/inspector/"+inspector+"/revision/"+revision+"/etapa/"+idEtapa+"/comentario/"+$(this).val()+"", function(response){
		});
	});
	$("#nr").modal('hide');

	$.get("apruebaRevision/"+revision+"/cantidadAprobadas/"+cantidadAprobadas+"", function(response){
		if ($("#pintura").text() == "MISCELANEOS") {
			$.get('anadeEtapaId/'+$('#pieza').val()+"/etapa/"+idEtapa+'/habilitado/'+1+'');
		}else{

		}
		alert("Se ha terminado de revisar: se aprobaron: "+cantidadAprobadas+" y tienen observaciones: "+contadorRech+"");
		$
		actualizaCantidad();
		reset();
	});
});

function validaAprobacion(){
	if ($("#cantidad").val() != "") {
		if ($("#lote").val() != "") {
			if (parseInt($("#piezasAprobadas").val()) <= parseInt($("#lote").val())) {
				if (parseInt($("#piezasAprobadas").val()) <= parseInt(paraAprobar)) {
					if (parseInt($("#piezasAprobadas").val()) == parseInt(paraAprobar)) {
						contadorA = $("#piezasAprobadas").val();
						if (revision == 0) {
						}else{
							var cantidadAprobadas = parseInt($("#lote").val())-parseInt(contadorRech);
							$("#nRegistro").val()
							$("#nr").modal();
							$("#individual").empty();
							for (var i = 0; i < cantidadAprobadas; i++) {
								console.log(i);
								$("#individual").append("<option id='"+(i+1)+"' value='"+i+"'>"+(i+1)+"</option>");
							}
							$('#individual').selectpicker('refresh');
						}
					}else{
						aprobadas = event.target.value;
					}
				}else{
					alert("Las piezas aprobadas no pueden exceder la cantidad de piezas a para aprobar. El porcentaje de aprobacion es "+$("#muestra").val()+"% = "+paraAprobar+" pieza(s)");
					$("#piezasAprobadas").val(paraAprobar);
					validaAprobacion();
				}
			}else{
				$("#piezasAprobadas").val("");
				alert("Las piezas aprobadas no pueden exceder el tamaño del lote");
			}
		}else{
			$("#piezasAprobadas").val("");
			alert("Aun no se ha ingresado la cantidad del lote");
		}
	}else{
		$("#piezasAprobadas").val("");
		alert("Aun no se ha seleccionado una pieza");
	}
}

function reset(){
	$.get("setComentarioCYP/"+revision+"/comentario/"+$("#comentario").val()+"", function(){
		revision = 0;
		$("#comentario").val("");
	});
	pieza = 0;
	idPiezaOB = 0;
	consecutivo = 0;
	idObservacion= 0;
	cantidadPiezaConOB= 0;
	cantidadFallas= 0;
	rechazadas= 0;
	paraAprobar= 0;
	aprobadas= 0;
	revisadas= 0;
	status= 0;
	idEtapa = 4;
	nPieza =1;
	lote = 0;
	contadorA = 0;
	contadorRev = 0;
	contadorRech = 0;
	revision = 0;
	$("#paraAprobar").val(0);
	$("#cantidad").val(0);
	$("#revisadas").val(0);
	$("#piezasRechazadas").val(0);
	$("#lote").val(0);
	$("#aRevisar").val(0);
	$("#piezasAprobadas").val(0);
	$("#piezasRestantes").val(0);
	$("#lote").attr('readonly',false);
	actualizaCantidad();
	regresar();
}

function ddpiezasob($pieza){
	$.get("piezasOB/"+$pieza+"",function(response, state){
		if (parseInt(response.length) > 0) {
			$("#piezaOB").empty();
			for(i = 0; i<response.length;i++){
				$("#piezaOB").append("<option value='"+response[i].idObservaciones+"'>"+('0000000'+response[i].idObservaciones).slice(-10)+"</option>");
				console.log(response[i]);
			}
			cantidadPiezaConOB = response.length;
			$('#piezaOB').selectpicker('refresh');

		}else{
			$('#piezaOB').empty();
			$('#piezaOB').append("<option value='placeholder'>--con OB--</option>");
			$('#piezaOB').selectpicker('refresh');
		}
	});
}

function actualizaCantidad(){
	$("#revision").css('display', 'none');
	$("#tablaErrores").css('display','none');
	$("#formularioModificacion").modal('hide');
	$.get("cantidadPieza/"+$("#proyecto").val()+"/pieza/"+$("#pieza").val()+"",function(response, state){
		$("#cantidad").val(response[0].CANTIDAD);
	});
	ddpiezasob($("#pieza").selectpicker('val'));
	$.get("piezasAprobadas/"+$("#pieza").selectpicker('val')+"", function(response, state){
		aprobadas = response;
		$("#aceptadas").val(aprobadas);
		$.get("nPiezasEnOb/"+$("#pieza").selectpicker('val')+"",function(response, state){
			$.get("getRechazadas/"+$("#pieza").selectpicker('val')+"", function(response, state){
				rechazadas = (response.length);
				$("#piezasRechazadas").val(rechazadas);
				revisadas = parseInt(aprobadas) + parseInt(rechazadas);
				$("#revisadas").val(revisadas);
				$("#piezasRestantes").val(parseInt($("#cantidad").val())-parseInt(revisadas));
			});
		});
	});
}

function actualizaAprobar(){
	paraAprobar = Math.ceil(parseInt($("#lote").val()) * (parseInt($("#muestra").val()) / parseInt(100)));
	$("#paraAprobar").val(paraAprobar);
}

function regresar(){
	$("#preRevision").show();
	$("#revision").hide();
	$("#tablaErrores").hide();
	$("#formularioModificacion").modal('hide');
	$("#informacion1").show();
	$("#informacion2").show();
	$("#preRevisar").show();
	$("#botonesInfo").show();
	$("#rerevision").css({
		'cursor': '',
		'pointer-events': '',
		'background-color': ''
	});
}

function anadirRevision(){
	if ($("#revisionPlano").val()) {
		$.get("anadirRevisionCYP/"+revision+"/revisionPlano/"+$("#revisionPlano").val()+"");
		return true;
	}else{
		alert("Necesita añadir una revision");
		return false;
	}
}