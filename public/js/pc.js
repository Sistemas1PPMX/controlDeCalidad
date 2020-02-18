var inspector;
var cantidad;
var revision = 0;
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
var idEtapa = 7;
var nPieza =1;
var piezaSeleccionada;
var contadorA = 0;
var contadorRev = 0;
var contadorRech = 0;
var cantidad;

function regresar(){
	$("#principal").show();
	$("#revision").hide();
}

$("#btnRegresarRevision").click(function(event) {
	regresar();
});

$("#btnRegresarFallas").click(function(event) {
	regresar();
});

$(document).ready(function() {

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
	$('select').selectpicker();
	$('select').selectpicker('render');

	$.get("pinturaGetLotes", function(response, state){
		for (var i = 0; i < response.length; i++) {
			$("#lote").append('<option value="'+response[i].idLotePintura+'">'+response[i].codigoLote+'</option>');
		}
		$("#lote").selectpicker('refresh');
	});

	$.get("regresaInspector/"+$("#inspector").text()+"", function(response, state){
		$("#usuario").append(response[0].nombreUsuario);
		inspector = $("#inspector").text();

	});

	$("#revision").hide();
});

$("#lote").on('changed.bs.select', function(event){
	$("#tablainfo tr:not(:first)").remove();
	$.get("pinturaGetPiezasP/"+$("#lote").val()+"", function(response, state){
		for (var i = 0; i < response.length; i++) {
			$("#tablainfo").append("<tr><td id='pieza'>"+response[i].nombrePieza+"</td><td><input type='checkbox' style='width:100%' id='preparacion'></td><td><input type='checkbox' style='width:100%' id='c1'></td><td><input type='checkbox' style='width:100%' id='c2'></td><td><input type='checkbox' style='width:100%' id='c3'></td><td><input type='button' class='btn btn-block btn-primary' id='observacion' value='OBSERVACION'></td></tr>");
		}
	});
});

$("#btnPreparacion").click(function(event){
	$("#tablainfo > tr").each(function(){
		$(this).each(function(){
			$(this).find("input[id='preparacion']").prop('checked', true);
		})
	});
});

$("#btnC1").click(function(event){
	$("#tablainfo > tr").each(function(){
		$(this).each(function(){
			$(this).find("input[id='c1']").prop('checked', true);
		})
	});
});

$("#btnC2").click(function(event){
	$("#tablainfo > tr").each(function(){
		$(this).each(function(){
			$(this).find("input[id='c2']").prop('checked', true);
		})
	});
});

$("#btnC3").click(function(event){
	$("#tablainfo > tr").each(function(){
		$(this).each(function(){
			$(this).find("input[id='c3']").prop('checked', true);
		})
	});
});

$("#tablainfo").on('click', 'input[id="observacion"]', function(event){
	$("#principal").hide();
	$("#revision").show();
	piezaSeleccionada = $(this).closest('tr').find("td[id='pieza']").text()
});

//depurar

$("#btnObservacion").click(function(event){
	$("#formObservacion").css('visibility','visible');
	/*$("#btnAceptar").css('visibility','hidden');*/
	$("#btnGuardar").css('visibility','visible');
	$("#errores").css('visibility','visible');
	$.get("pinturaCreaRevision/"+$("#lote").val()+"/usuario/"+$("#inspector").text()+"/etapa/"+idEtapa+"", function(response, state){
		idRevision = response;
		$("#piezaActual").text(piezaSeleccionada)
	});
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
});


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
		$("#info").hide();
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
	/*var comentario = "Se inicio una re-revision de la observacion "+ $("#piezaOB option:selected").text()+"";
	$.get('armadoContadorRevision/'+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+ $("#piezaOB").val() +"/falla/"+null+"/comentario/"+comentario+"");*/
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
				var comentario = "Se aprobo la falla "+valor[0]+ " de la observacion "+$("#piezaOB").val()+"";
				$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+valor[0]+"/comentario/"+comentario+"", function(response){

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
		if (parseInt(revision) == parseInt(0)) {
			$.get("apruebaParcial/"+$("#pieza").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
				$("#comentarioParcial").val("");
			});
			$("#comentarioParcial").val("");
		}else{
			$.get("apruebaParcialExiste/"+revision+"/pieza/"+$("#pieza").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
				$("#comentarioParcial").val("");
			});
			$("#comentarioParcial").val("");
			revision = 0;
		}
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
			$.get("aprueba/"+$("#pieza").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
				$("#comentarioParcial").val("");
			});
			var comentario = "La pieza "+$("#pieza option:selected").text()+" fue completamente aprobada";
			$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#pieza").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+null+"/falla/"+null+"/comentario/"+comentario+"", function(response){

			});
			$("#comentarioParcial").val("");
		}
	}
});

$("#btnRechazar").click(function(event){
	if (!$("#comentarioParcial").val()) {
		alert("El comentario no puede estar vacio");
	}else{		
		$.get("armadoRechazar/"+$("#pieza").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
			$("#comentarioParcial").val("");
		});
		var comentario = "La pieza "+$("#pieza option:selected").text()+" fue completamente rechazada";
		$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#pieza").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+null+"/falla/"+null+"/comentario/"+comentario+"", function(response){

		});
		$("#comentarioParcial").val("");
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
			$.get("armadoCrearObservacion/"+idPiezaOB+"/inspector/"+inspector+"",function(response, state){
				var comentario = "Se añade una observacion a la revision";
				$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#pieza").val()+"/etapa/"+idEtapa+"/revision/"+revision+"/observacion/"+response+"/falla/"+null+"/comentario/"+comentario+"", function(response){

				});
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
		$("#comentarioParcial").val("");
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
		var comentario = "Se actualizo la falla "+ $("#idFalla").text() +" de la observacion "+$("#piezaOB option:selected").text()+"";
		$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#pieza").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+$("#idFalla").text()+"/comentario/"+comentario+"", function(response){

		});
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
				'background-color:': '' 
			});
		});
	});
});

$("#btnIgual").click(function(event){

	var comentario = "Termino la revision de la observacion "+$("#piezaOB option:selected").text()+" sin cambios";
	$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#pieza").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+null+"/comentario/"+comentario+"", function(response){
		actualizaCantidad();
		regresar();
	});
});