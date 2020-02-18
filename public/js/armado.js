
var inspector;
var cantidad;
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
var idEtapa = 5;
var nPieza =1;
var piezaSeleccionada;
var contadorA = 0;
var contadorRev = 0;
var contadorRech = 0;


$(document).ready(function(){

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

	$("#piezasRechazadas").val("0");

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
	$("#cantidad").val("0");
	$("#piezasRestantes").val("0");
	$("#revisadas").val("0");
	$("#rechazadas").val("0");
	$("#aceptadas").val("0");

	$('#proyecto').selectpicker('reload');
	$('#pieza').selectpicker('reload');
	$('#piezaArmado').selectpicker('reload');
	$('#piezaOB').selectpicker('reload');

	$.get("armadoGetPiezas/"+$("#proyecto").val()+"",function(response, state){
		$("#pieza").empty();
		for(i = 0; i < response.length; i++){
			$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].marca+"</option>");
		}
		$('#pieza').selectpicker('refresh');
		$.get("armadoGetCantidadStrumis/"+$("#pieza").val()+"", function(response){
			$("#cantidad").val(response[0].cantidad);
		});
		creaPiezas();
		/*actualizaCantidad();*/
	});
	$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
		$("#info").empty();
		for (var i = 0; i < response.length; i++) {
			$("#info").append("<div><label>"+response[i].idRevision+" usuario: 	"+response[i].nombreUsuario+" comentario: 	"+response[i].comentario+" fecha: 	"+response[i].fechaRevision+"</label></div>");
		}
	});
});

function actualizaCantidad(){
	$.get("armadoGetPiezaConsecutivo/"+$("#pieza").val()+"", function(response){
		$("#aceptadas").val("0");
		$("#piezasRechazadas").val("0");
		$("#revisadas").val("0");
		for (var i = 0; i < response.length; i++) {
			if (i == 0) {
				$("#status").val(response[i].status);
			}
			if (response[i].idStatus == 1) {
				$("#aceptadas").val(parseInt($("#aceptadas").val()) + parseInt(1));
			}else if (response[i].idStatus == 3) {
				$("#piezasRechazadas").val(parseInt($("#piezasRechazadas").val()) + parseInt(1));
			}else if (response[i].idStatus == 2){
				$("#revisadas").val(parseInt($("#revisadas").val() + parseInt(1)));
			}
		}
		var restantes = 0;
		restantes = parseInt($("#cantidad").val())-(parseInt($("#aceptadas").val())+parseInt($("#piezasRechazadas").val()));
		console.log(restantes);
		$("#piezasRestantes").val(restantes);
	});
	$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
		$("#info").empty();
		for (var i = 0; i < response.length; i++) {
			$("#info").append("<div><label>REVISION:   "+(i+parseInt(1))+"   USUARIO:   "+response[i].nombreUsuario+"   COMENTARIO:   "+response[i].comentario+"   FECHA:   "+response[i].fechaRevision+"</label></div>");
		}
	});

	ddpiezasob($("#piezaArmado").val());
}

function creaPiezas(){
	$.get("armadoGetCantidadStrumis/"+$("#pieza").val()+"", function(response){
		$("#cantidad").val(response[0].cantidad);
	});
	$.get("armadoGetCantidadCC/"+$("#pieza").val()+"", function(response){
		/*$("#cantidad").val(response[0].cantidad);*/
		if (response[0].cantidad < $("#cantidad").val()) {
			for (var i = 0; i < $("#cantidad").val(); i++) {
				$.get("armadoCreaPieza/"+$("#proyecto").val()+"/pieza/"+$("#pieza").val()+"/consecutivo/"+(i+1)+"", function(response){
				})
			}
			piezaIndividual()
		}else if (parseInt(response[0].cantidad) == parseInt($("#cantidad").val())) {
			piezaIndividual();
		}else {
			alert("Se han eliminado piezas de Strumis");
			piezaIndividual()
		}
	});
}

function limpiarContador(){
	$("#aceptadas").val("");
	$("#piezasRechazadas").val("");
	$("#revisadas").val("");
}

function piezaIndividual(){
	$("#piezaArmado").empty();
	$.get("armadoGetInfo/"+$("#pieza").val()+"", function(response){
		//OPTIMIZAR EN UN SOLO METODO
		var nombre = response[0].nombre;
		$.get("armadoGetPiezaConsecutivo/"+$("#pieza").val()+"", function(response){
			$("#aceptadas").val("0");
			$("#piezasRechazadas").val("0");
			$("#revisadas").val("0");

			for (var i = 0; i < response.length; i++) {
				if (i == 0) {
					$("#status").val(response[i].status);
				}
				if (response[i].idStatus == 1) {
					$("#aceptadas").val(parseInt($("#aceptadas").val()) + parseInt(1));
				}else if (response[i].idStatus == 3) {
					$("#piezasRechazadas").val(parseInt($("#piezasRechazadas").val()) + parseInt(1));
				}else if (response[i].idStatus == 2){
					$("#revisadas").val(parseInt($("#revisadas").val() + parseInt(1)));
				}
				$("#piezaArmado").append("<option value='"+response[i].id+"'>"+nombre+"-"+response[i].consecutivo+"</option>");
			}
			var restantes = 0;
			restantes = parseInt($("#cantidad").val())-(parseInt($("#aceptadas").val())+parseInt($("#piezasRechazadas").val()));
			console.log(restantes);
			$("#piezasRestantes").val(restantes);
			$('#piezaArmado').selectpicker('refresh');
			$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
				$("#info").empty();
				for (var i = 0; i < response.length; i++) {
					$("#info").append("<div><label>REVISION: "+(i+parseInt(1))+"   USUARIO:   "+response[i].nombreUsuario+"   COMENTARIO:   "+response[i].comentario+"   FECHA:   "+response[i].fechaRevision+"</label></div>");				}
				});
			$.get("armadoGetAprobadas/"+$('#piezaArmado').selectpicker('val')+"",function(response){
				ddpiezasob($('#piezaArmado').selectpicker('val'));
				/*$("#aceptadas").val(response);*/
			});
			$.get("armadoGetRechazadas/"+$('#pieza').selectpicker('val')+"", function(response){
				/*$("#piezasRechazadas").val(response[0].pieza);*/
				$.get('getRevisadas/'+$("#pieza").val()+'',function(response,state){
					/*$("#revisadas").val(response[0].revisadas);*/
				});
				/*$("#piezasRestantes").val(parseInt($("#cantidad").val())-parseInt($("#revisadas").val()));*/
				ddpiezasob($("#piezaArmado").selectpicker('val'));
			});
		});
	});
}

function regresar(){
	$("#rerevision").removeAttr('style');
	$("#revision").css({
		display: 'none',
	});
	$("#tablaErrores").css('display', 'none');
	$("#formularioModificacion").css('display','none');
	$("#informacion1").css('display', 'flex');
	$("#informacion2").css('display', 'flex');
	$("#preRevisar").css('display', 'flex');
	$("#botonesInfo").css('display', 'flex');
	$("#btnAceptarParcial").show();
	$("#btnAceptar").show();
}

function ddpiezasob($pieza){
	$.get("armadoPiezasOB/"+$pieza+"",function(response, state){
		/*alert(response.length);*/
		if (response.length > 0) {
			$("#piezaOB").empty();
			for(i = 0; i<response.length;i++){
				$("#piezaOB").append("<option value='"+response[i].idObservaciones+"'>"+('0000000'+response[i].idObservaciones).slice(-10)+"</option>");
				/*console.log(response[i]);*/
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

$("#btnRegresarRevision").click(function(event) {
	actualizaCantidad();
	regresar();
});

$("#btnRegresarFallas").click(function(event) {
	actualizaCantidad();
	regresar();
});

$("#btnNuevaRevisionParcial").click(function(event){
	if ($("#status").val() === "Pendiente" || $("#status").val() === "Parcial") {

		if ($("#piezasRestantes").val()>=0) {
			$("#piezaActual").text(nPieza);
			$("#informacion1").css('display','none');
			$("#botonesInfo").css('display','none');
			$("#informacion2").css('display','none');
			$("#tablaErrores").css('display','none');
			$("#revision").css('display','block');
			$("#btnAceptar").hide();
			$("#btnRechazar").hide();
			$("#btnAceptarParcial").show();

			$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
				$("#info").empty();
				for (var i = 0; i < response.length; i++) {
					$("#info").append("<div><label>REVISION:   "+(i+parseInt(1))+"   USUARIO:   "+response[i].nombreUsuario+"   COMENTARIO:   "+response[i].comentario+"   FECHA:   "+response[i].fechaRevision+"</label></div>");				}
				});
		}
	}else{
		alert($("#status").val());
	}
});

$("#btnNuevaRevision").click(function(event){
	if ($("#status").val() === "Pendiente" || $("#status").val() === "Parcial") {
		if ($("#piezasRestantes").val()>=0) {
			$("#piezaActual").text(nPieza);
			$("#informacion1").css('display','none');
			$("#botonesInfo").css('display','none');
			$("#informacion2").css('display','none');
			$("#tablaErrores").css('display','none');
			$("#revision").css('display','block');
			$("#btnAceptarParcial").hide();
			$("#btnAceptar").show();
			$("#btnRechazar").show();
		}
	}else{
		alert($("#status").val());
	}
});

$("#proyecto").on('changed.bs.select', function(event){
	$.get("armadoGetPiezas/"+$("#proyecto").val()+"",function(response, state){
		$("#pieza").empty();
		for(i = 0; i < response.length; i++){
			$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].marca+"</option>");
		}
		$('#pieza').selectpicker('refresh');
		/*actualizaCantidad();*/
		creaPiezas();
	});

});

$("#pieza").on('changed.bs.select', function(event){
	creaPiezas();
	ddpiezasob($("#piezaArmado").val());
});

$("#piezaArmado").on('hidden.bs.select', function(event){
	$.get('armadoGetStatus/'+$("#piezaArmado").val()+'', function(response, state){
		$("#status").val(response[0].status);
	});
	ddpiezasob($("#piezaArmado").val());
	$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
		$("#info").empty();
		for (var i = 0; i < response.length; i++) {
			$("#info").append("<div><label>REVISION:   "+(i+parseInt(1))+"   USUARIO:   "+response[i].nombreUsuario+"   COMENTARIO:   "+response[i].comentario+"   FECHA:   "+response[i].fechaRevision+"</label></div>");
		}
	});
});

$("#btnObservacion").click(function(event){
	$("#formObservacion").css('visibility','visible');
	/*$("#btnAceptar").css('visibility','hidden');*/
	$("#btnGuardar").css('visibility','visible');
	$("#errores").css('visibility','visible');
	if ($("#btnAceptarParcial").is(":hidden")) {
		/*alert("Total"); */
		$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").selectpicker('val')+"/inspector/"+inspector+"/etapa/"+idEtapa+"/parcial/"+false+"/", function(response, state){
			revision = response;
		});
	}else{
		/*alert("Parcial")*/
		$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").selectpicker('val')+"/inspector/"+inspector+"/etapa/"+idEtapa+"/parcial/"+1+"/", function(response, state){
			revision = response;
		});
	}
});

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

$("#errores").on('click', 'input[type="button"]', function(e){
	$(this).closest('tr').remove()
})


$("#btnGuardar").click(function(event){
	var cantidadAprobadas = parseInt($("#lote").val())-parseInt(contadorRech);
	$.get("apruebaRevision/"+revision+"/cantidadAprobadas/"+cantidadAprobadas+"", function(response){
		alert("Se ha terminado de revisar: se aprobaron: "+cantidadAprobadas+" y tienen observaciones: "+contadorRech+"");
		actualizaCantidad();
		reset();
	});
});

$("#btnCancelar").click(function(event){
	reset();
});

$("#piezaOB").on('hidden.bs.select',function(event){
	idObservacion = event.target.value;
	if ($("#piezaOB").val() != "placeholder") {
		$("#informacion1").css('display','none');
		$("#botonesInfo").css('display','none');
		$("#informacion2").css('display','none');
		$("#revision").css('display', 'none');
		$("#tablaErrores").css('display','block');
		$("#btnEliminaFalla").css('display','block');
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
		$("#observacionM").val(response[0].ComentarioFalla);
		$('#tipoFallaM').selectpicker('refresh');
		$('#supervisorM').selectpicker('refresh');
		$('#indicacionM').selectpicker('refresh');
		$("#formularioModificacion").css("display","block");
	});
});

$("#btnEliminaFalla").click(function(event){
	var valor = [];
	$("#erroresExiste").find('input[name="pendiente"]').each(function(){
		if($(this).val() == "En liberacion"){
			$(this).parents("tr").each(function(){
				$(this).find("td").each(function(){
					valor.push($(this).text());
				});
				$.get("eliminaFalla/"+valor[0]+"", function(response, state){
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

$("#btnAceptarParcial").click(function(event){
	/*alert("Se inicia proceso para el guardar la aprobacion parcial "+"idRevision: $id"+" Comentario: "+$("#comentarioParcial").val());*/
	if (!$("#comentarioParcial").val()) {
		alert("El comentario no puede estar vacio");
	}else{
		$.get("apruebaParcial/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
			$("#comentarioParcial").val("");
		});
		$("#comentarioParcial").val("");
	}
});

$("#btnAceptar").click(function(event){
	if (!$("#comentarioParcial").val()) {
		alert("El comentario no puede estar vacio");
	}else{
		var cantidad = $("#piezaOB option").length;
		if (cantidad >= parseInt(1) && $("#piezaOB").val() != "placeholder") {
			/*alert(cantidad);*/
			alert("La pieza aun contiene observaciones activas, no se puede aceptar");
		}else{
			$.get("aprueba/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
				$("#comentarioParcial").val("");
			});
		}
	}
});

$("#btnRechazar").click(function(event){
	if (!$("#comentarioParcial").val()) {
		alert("El comentario no puede estar vacio");
	}else{		
		$.get("armadoRechazar/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
			$("#comentarioParcial").val("");
		});
	}
});

$("#btnGuardarObservacion").click(function(){
	$("#formObservacion").css('visibility','hidden');
	$("#btnAceptar").css('visibility','visible');
	$("#errores").css('visibility','hidden');	
	if (parseInt($("#errores tr").length) > 1) {
		$.get("crearPiezaOB/"+revision+"/consecutivo/"+1+"",function(response, state){
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

$("#guardarModificacion").click(function(event){
	$.get("armadoActualizaFalla/"+$("#idFalla").text()+"/tipoFalla/"+$("#tipoFallaM").val()+"/comentario/"+$("#comentarioM").val()+"/supervisor/"+$("#supervisorM").val()+"/indicacion/"+$("#indicacionM").val()+"/observacion/"+$("#observacionM").val()+"", function(response, state){
		$("#formularioModificacion").hide();
		$("#erroresExiste tr:not(:first)").remove();
		$.get("regresaFallas/"+$("#piezaOB").val()+"", function(response, state){
			for(i = 0; i<response.length;i++){
				var markup = "<tr><td>"+response[i].idFallas+"</td><td>"+response[i].idObservacion+"</td><td>"+response[i].descripcionTipoFalla+"</td><td>"+response[i].comentarioFalla+
				"</td><td>"+response[i].supervisorqi+"</td><td>"+response[i].indicacion+"</td><td>"+response[i].observaciones+"</td><td><input type='button' name='pendiente' class='btn btn-danger text-center rerevision' value='Pendiente' style='width: 50%; display: none;'><input type='button' name='modificar' class='btn btn-warning text-center rerevision' value='Modificar' style='width: 50%; display: none;'></td></tr>";	
				$("#erroresExiste").append(markup);
			}	

			$("#rerevision").css({
				'cursor': '',
				'pointer-events': '',
				'background-color': ''
			});
		});
	});
});