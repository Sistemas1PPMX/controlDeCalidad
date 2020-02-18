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
var idEtapa = 5;
var nPieza =1;
var piezaSeleccionada;
var contadorA = 0;
var contadorRev = 0;
var contadorRech = 0;
var cantidad;


$(document).ready(function(){
	$("#rerevision").removeAttr('style');
	$("#revision").hide();
	$("#tablaErrores").hide();
	$("#formularioModificacion").hide();
	$("#preRevisar").show();
	$("#botonesInfo").show();
	$("#btnAceptarParcial").show();
	$("#btnAceptar").show();
	$("#informacion1").show();
	$("#informacion2").hide();
	$("#info").show();
	$("#preRevision").show();
	$("#formObservacion").hide();
	$("#tabla").hide();
	$(".rerevision").hide();

	$.get("regresaInspector/"+$("#inspector").text()+"", function(response, state){
		$("#usuario").append(response[0].nombreUsuario);
		inspector = $("#inspector").text();

	});

	$.get("getArmadores", function(response){
		for (var i = 0; i < response.length; i++) {
			$("#nombreArmador").append('<option value="'+response[i].idArmador+'">'+response[i].nombre+'</option>');
		}
		$("#nombreArmador").selectpicker('reload');
		$("#nombreArmador").selectpicker('refresh');
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

	$("#refabricacion").hide();

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
			$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].marca+"("+response[i].cantidad+")"+"</option>");
		}
		$('#pieza').selectpicker('refresh');
		$.get("armadoGetCantidadStrumis/"+$("#pieza").val()+"", function(response){
			cantidad = response[0].cantidad;
		});
		creaPiezas();
		/*actualizaCantidad();*/
	});
	/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
		$("#info tr:not(:first)").remove();
		for (var i = 0; i < response.length; i++) {
			$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
		}
	});*/

	$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
		$("#info tr:not(:first)").remove();
		var evento;
		var x = 1;
		for (var i = 0; i < response.length; i++) {
			if (response[i].evento == "AP") {
				evento = response[i].evento+x.toString();
				x++;
			}else{
				evento = response[i].evento;
			}
			$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
		}
	});
});

$('#piezaInput').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		alert("Evento cuando se presiona enter  " + $("#piezaInput").val());
		$("#piezaInput").val("");
	}else{
		string = $("#piezaInput").val();
		$("#piezaInput").val(string+String.fromCharCode(keycode));
		/*$("#piezaInput").append(String.fromCharCode(keycode));*/
	}
});

function actualizaCantidad(){
	$.get("armadoGetPiezaConsecutivo/"+$("#pieza").val()+"", function(response){
		$("#aceptadas").val("0"); $("#piezasRechazadas").val("0");
		$("#revisadas").val("0"); for (var i = 0; i < response.length; i++) { if (i ==
			0) { $("#status").val(response[i].status); } if (response[i].idStatus == 1) {
			$("#aceptadas").val(parseInt($("#aceptadas").val()) + parseInt(1)); }else if
			(response[i].idStatus == 3) {
				$("#piezasRechazadas").val(parseInt($("#piezasRechazadas").val()) +
					parseInt(1)); }else if (response[i].idStatus == 2){
					$("#revisadas").val(parseInt($("#revisadas").val() + parseInt(1))); } } var
					restantes = 0; restantes =
					parseInt(cantidad)-(parseInt($("#aceptadas").val())+parseInt($("#piezasRechazadas").val()));
					console.log(restantes); $("#piezasRestantes").val(restantes); 
				});
	/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response,
		state){ $("#info tr:not(:first)").remove(); for (var i = 0; i <
		response.length; i++) {
			$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
		} });*/
		$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
			$("#info tr:not(:first)").remove();
			var evento;
			var x = 1;
			for (var i = 0; i < response.length; i++) {
				if (response[i].evento == "AP") {
					evento = response[i].evento+x.toString();
					x++;
				}else{
					evento = response[i].evento;
				}
				$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
			}
		});

		ddpiezasob($("#piezaArmado").val());
	}

	function creaPiezas(){
		$.get("armadoGetCantidadStrumis/"+$("#pieza").val()+"", function(response){
			cantidad = response[0].cantidad;
			console.log(cantidad);
			$.get("armadoGetCantidadCC/"+$("#pieza").val()+"", function(response){
				/*$("#cantidad").val(response[0].cantidad);*/
				if (response[0].cantidad < cantidad) {
					for (var i = 0; i < cantidad; i++) {
						$.get("armadoCreaPieza/"+$("#proyecto").val()+"/nombreProyecto/"+$("#proyecto option:selected").text()+"/pieza/"+$("#pieza").val()+"/nombre/"+$("#pieza option:selected").text()+"/consecutivo/"+(i+1)+"", function(response){
						})
					}
				//setTimeout(piezaIndividual(),100);
				$("#piezaArmado").find('option').not(':first').remove();
				$("#piezaArmado").selectpicker('refresh');
			}else if (parseInt(response[0].cantidad) == parseInt(cantidad)) {
				piezaIndividual();
			}else {
				alert("Se han eliminado piezas de Strumis");
				console.log(parseInt(response[0].cantidad));
				console.log(parseInt(cantidad));
				piezaIndividual()
			}
		});
		});
	}

	$("#piezaArmado").on('show.bs.select',function(event){
		piezaIndividual();
	});


	function limpiarContador(){
		$("#aceptadas").val("");
		$("#piezasRechazadas").val("");
		$("#revisadas").val("");
	}

	function piezaIndividual(){
		$("#piezaArmado").find('option').not(':first').remove();	
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
			restantes = parseInt(cantidad)-(parseInt($("#aceptadas").val())+parseInt($("#piezasRechazadas").val()));
			$("#piezasRestantes").val(restantes);
			$('#piezaArmado').selectpicker('refresh');
			$.get("getInfoParcial/"+$("#piezaArmado").val()+"", function(response, state){
				$("#info tr:not(:first)").remove();
				for (var i = 0; i < response.length; i++) {
					$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
				}
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
		$("#nRevision").val("");
		$("#rerevision").removeAttr('style');
		$("#revision").hide();
		$("#tablaErrores").hide();
		$("#formularioModificacion").hide();
		$("#preRevisar").show();
		$("#botonesInfo").show();
		$("#btnAceptarParcial").show();
		$("#btnAceptar").show();
		$("#informacion1").show();
		$("#informacion2").hide()
		$("#info").show();
		$("#preRevision").show();
		$("#formObservacion").hide();
		$(".rerevision").hide();
		$("#nombreArmador").selectpicker('deselectAll');
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
		/*$("#preRevision").hide();*/
		if (($("#status").val() === "Pendiente" || $("#status").val() === "Parcial" || $("#status").val() === "Refabricacion") && $("#piezaArmado").val() != 'placeholder') {
			if ($("#nRevision").val()) {
				$("#info").hide();
				$("#piezaActual").text(nPieza);
				$("#informacion1").hide();
				$("#botonesInfo").hide();
				$("#informacion2").hide();
				$("#tablaErrores").hide();
				$("#revision").show();
				$("#btnAceptar").hide();
				$("#btnRechazar").hide();
				$("#btnAceptarParcial").show();
				$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").val()+"/inspector/"+inspector+"/etapa/"+5+"/parcial/"+1+"",function(response){
					revision = response;
				});
			}else{
				alert("se debe ingresar un numero de revision");
			}
		/*$("#tablaErrores").hide();
		$("#tabla").show();*/

		/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
			$("#info tr:not(:first)").remove();
			for (var i = 0; i < response.length; i++) {
				$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
			}
		});*/
		
	}else{
		if ($("#piezaArmado").val() == 'placeholder') {
			alert("No se selecciono una pieza individual");
		}else{
			alert($("#status").val());
		}
		/*$("#info").show();
		$("#preRevision").show();*/
	}
});

	$("#btnNuevaRevision").click(function(event){
		if (($("#status").val() === "Pendiente" || $("#status").val() === "Parcial" || $("#status").val() === "Refabricacion") && $("#piezaArmado").val() != 'placeholder') {
			if ($("#nRevision").val()) {
				$("#info").hide();
				$("#piezaActual").text(nPieza);
				$("#informacion1").hide();
				$("#botonesInfo").hide();
				$("#informacion2").hide();
				$("#tablaErrores").hide();
				$("#revision").show();
				$("#btnAceptarParcial").hide();
				$("#btnAceptar").show();
				$("#btnRechazar").show();
				$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").val()+"/inspector/"+inspector+"/etapa/"+5+"/parcial/"+0+"",function(response){
					revision = response;
				});
			}else{
				alert("se debe ingresar un numero de revision");
			}
		}else{
			if ($("#piezaArmado").val() == 'placeholder') {
				alert("No se selecciono una pieza individual");
			}else{
				alert($("#status").val());
			}
		}
	});

	$("#proyecto").on('changed.bs.select', function(event){
		$.get("armadoGetPiezas/"+$("#proyecto").val()+"",function(response, state){
			$("#pieza").empty();
			for(i = 0; i < response.length; i++){
				$("#pieza").append("<option value='"+response[i].id+"'>"+response[i].marca+"("+response[i].cantidad+")"+"</option>")
			}
			$('#pieza').selectpicker('refresh');
			/*actualizaCantidad();*/
			creaPiezas();
		});

	});

	$("#pieza").on('changed.bs.select', function(event){
		regresar();
		creaPiezas();
		ddpiezasob($("#piezaArmado").val());
		$("#informacion2").show();
		$("#informacion1").hide();
		$("#info").hide();
		$("#revision").hide();
		$("#botonesInfo").show();
	});

	$("#piezaArmado").on('hidden.bs.select', function(event){
		$("#nombreArmador").selectpicker('deselectAll');
		if (revision > 0) {
			if (confirm('Al cambiar de pieza la revision actual se cerrara')) {
				regresar();
				revision = 0;
				$("#formObservacion").hide();
				$("#btnAceptar").show();
				$("#errores").hide();	

				if (String($("#piezaArmado").val()) !== String("placeholder")) {
					console.log($("#piezaArmado").val());
					$("#informacion2").hide();
					$("#informacion1").show();
					$("#info").show();
					$("#infoTabla").show();
					$.get('armadoGetStatus/'+$("#piezaArmado").val()+'', function(response, state){
						$("#status").val(response[0].status);
					});
					ddpiezasob($("#piezaArmado").val());
					/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
						$("#info tr:not(:first)").remove();
						for (var i = 0; i < response.length; i++) {
							$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
						}
					});*/
					$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
						$("#info tr:not(:first)").remove();
						var evento;
						var x = 1;
						for (var i = 0; i < response.length; i++) {
							if (response[i].evento == "AP") {
								evento = response[i].evento+x.toString();
								x++;
							}else{
								evento = response[i].evento;
							}
							$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
						}
					});
					$("#refabricacion").show();
				}else{
					$("#informacion2").show();
					$("#informacion1").hide();
					$("#info").hide();
				}
			} else {
			}
		}else{
			regresar();
			if (String($("#piezaArmado").val()) !== String("placeholder")) {
				console.log($("#piezaArmado").val());
				$("#informacion2").hide();
				$("#informacion1").show();
				$("#info").show();
				$("#infoTabla").show();
				$.get('armadoGetStatus/'+$("#piezaArmado").val()+'', function(response, state){
					if (response.length > 0) {
						$("#status").val(response[0].status);
					}else{
						$("#status").val("Pendiente");
					}
				});
				ddpiezasob($("#piezaArmado").val());
				/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
					$("#info tr:not(:first)").remove();
					for (var i = 0; i < response.length; i++) {
						$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
					}
				});*/
				$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
					$("#info tr:not(:first)").remove();
					var evento;
					var x = 1;
					for (var i = 0; i < response.length; i++) {
						if (response[i].evento == "AP") {
							evento = response[i].evento+x.toString();
							x++;
						}else{
							evento = response[i].evento;
						}
						$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
					}
				});
				$("#refabricacion").show();
			}else{
				$("#informacion2").show();
				$("#informacion1").hide();
				$("#info").hide();
			}
		}
		$.get('getRevisionArmado/'+$("#piezaArmado").val()+"", function(response){
			if (response.length == 0) {

			}else{
				/*$("#nRevision").val(response[0].revisionPlano);*/
			}
		});
	});

$("#refabricacion").click(function(event){
	if(confirm("¿La pieza fue refabricada?")){
		var comentario = "La pieza "+$("#piezaArmado option:selected").text()+" fue refabricada.";
		$.get("refabricacion/"+inspector+"/pieza/"+$("#piezaArmado").selectpicker('val')+"/etapa/"+idEtapa+"/comentario/"+comentario+"");
		alert("La pieza fue refabricada.");
		$("#informacion2").hide();
		$("#informacion1").show();
		$("#info").show();
		$("#infoTabla").show();
		$.get('armadoGetStatus/'+$("#piezaArmado").val()+'', function(response, state){
			$("#status").val(response[0].status);
		});
		ddpiezasob($("#piezaArmado").val());
			/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
				$("#info tr:not(:first)").remove();
				for (var i = 0; i < response.length; i++) {
					$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
				}
			});*/
			$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
				$("#info tr:not(:first)").remove();
				var evento;
				var x = 1;
				for (var i = 0; i < response.length; i++) {
					if (response[i].evento == "AP") {
						evento = response[i].evento+x.toString();
						x++;
					}else{
						evento = response[i].evento;
					}
					$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
				}
			});
			$("#refabricacion").show();
		}
		else{
		}
	});

$("#btnObservacion").click(function(event){
	$("#formObservacion").show();
	/*$("#btnAceptar").hide()*/
	$("#btnGuardar").show();
	$("#errores").show();
	$("#tabla").show();
	if ($("#btnAceptarParcial").is(":hidden")) {
		/*alert("Total"); */
		/*$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").selectpicker('val')+"/inspector/"+inspector+"/etapa/"+idEtapa+"/parcial/"+false+"/", function(response, state){
			revision = response;
		});*/
	}else{
		/*alert("Parcial")*/
		/*$.get("armadoCreaRevision/"+$("#proyecto").val()+"/pieza/"+$("#piezaArmado").selectpicker('val')+"/inspector/"+inspector+"/etapa/"+idEtapa+"/parcial/"+true+"/", function(response, state){
			revision = response;
		});*/
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
		var area;
		/*switch()*/
		var markup = "<tr><td>"+proyecto+"</td><td>"+pieza+"</td><td>"+lote+"</td><td>"+defecto.toUpperCase()+"</td><td>"+descripcion.toUpperCase()+"</td><td>"+$("#areaCargada option:selected").text().toUpperCase()+"</td><td>"+supervisor.toUpperCase()+"</td><td>"+indicacion.toUpperCase()+"</td><td>"
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
		$("#informacion1").hide();
		$("#botonesInfo").hide();
		$("#informacion2").hide();
		$("#revision").hide();
		$("#tablaErrores").show();
		$("#btnRegresarFallas").show();
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
	$(".rerevision").show();
	$(".rerevision").show();
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
		$("#formularioModificacion").show();
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
				$.get("eliminaFalla/"+valor[0]+"/inspector/"+inspector+"", function(response, state){
				});
				var comentario = "Se aprobo la falla "+valor[0]+ " de la observacion "+$("#piezaOB").val()+"";
				$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+valor[0]+"/comentario/"+comentario+"/nRevision/"+null+"", function(response){

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
		$("#tablaErrores").show();
	});
});

$("#btnAceptarParcial").click(function(event){
	/*alert("Se inicia proceso para el guardar la aprobacion parcial "+"idRevision: $id"+" Comentario: "+$("#comentarioParcial").val());*/
	$.get("apruebaParcialExiste/"+revision+"/pieza/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/revision/"+$("#nRevision").val()+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
		$("#comentarioParcial").val("");
		regresar();
			/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
				$("#info tr:not(:first)").remove();
				for (var i = 0; i < response.length; i++) {
					$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
				}
			});*/
			$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
				$("#info tr:not(:first)").remove();
				var evento;
				var x = 1;
				for (var i = 0; i < response.length; i++) {
					if (response[i].evento == "AP") {
						evento = response[i].evento+x.toString();
						x++;
					}else{
						evento = response[i].evento;
					}
					$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
				}
			});
		});
	$("#comentarioParcial").val("");
	revision = 0;
});

$("#btnAceptar").click(function(event){
	if ($("#nombreArmador").val() == '') {
		alert('Se debe seleccionar un armador')
	}else{
		var cantidad = $("#piezaOB option").length;
		if (cantidad >= parseInt(1) && $("#piezaOB").val() != "placeholder") {
			alert("La pieza aun contiene observaciones activas, no se puede aceptar");
		}else{
			var comentario = "La pieza "+$("#piezaArmado option:selected").text()+" fue completamente aprobada";
			$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+revision+"/observacion/"+null+"/falla/"+null+"/comentario/"+comentario+"/nRevision/"+$("#nRevision").val()+"", function(response){
				alert(comentario);
					/*$.get("getInfoAcciones/"+$("#piezaArmado").val()+"", function(response, state){
						$("#info tr:not(:first)").remove();
						for (var i = 0; i < response.length; i++) {
							$("#info").append("<tr><td>"+(i+parseInt(1))+"</td><td>"+response[i].nombre+"</td><td>"+response[i].pieza+"</td><td>"+response[i].etapa+"</td><td>"+response[i].revision+"</td><td>"+response[i].observacion+"</td><td>"+response[i].falla+"</td><td>"+response[i].comentario+"</td><td>"+response[i].fecha+"</td></tr>");				
						}
					});*/
					$.get("getHistorialArmado/"+$("#piezaArmado").val()+"", function(response){
						$("#info tr:not(:first)").remove();
						var evento;
						var x = 1;
						for (var i = 0; i < response.length; i++) {
							if (response[i].evento == "AP") {
								evento = response[i].evento+x.toString();
								x++;
							}else{
								evento = response[i].evento;
							}
							$("#info").append("<tr><td>"+response[i].fecha+"</td><td>"+response[i].nombre+"</td><td>"+response[i].revisionPlano+"</td><td>"+evento+"</td><td>"+response[i].comentario+"</td><td>"+response[i].numeroOB+"</td><td>"+response[i].ei+"</td><td>"+response[i].ComentarioFalla+"</td><td>"+response[i].observaciones+"</td><td>");
						}
					});
				});
			$.get('apruebaArmado/'+revision+'/pieza/'+$("#piezaArmado").val()+'/inspector/'+$("#inspector").text()+'/etapa/'+idEtapa+'/revision/'+$("#nRevision").val()+'/armador/'+$("#nombreArmador").val()+'/comentario/'+$("#comentarioParcial").val()+'',function(){
				$("#nombreArmador").selectpicker('deselectAll');
				regresar();
				actualizaCantidad();
				revision = 0;
			});
		}
	}
});



$("#btnRechazar").click(function(event){
	if (!$("#comentarioParcial").val()) {
		$("#comentarioParcial").val("Rechazada");
		$.get("armadoRechazar/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
			$("#comentarioParcial").val("");
		});
		var comentario = "La pieza "+$("#piezaArmado option:selected").text()+" fue completamente rechazada";
		$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+null+"/falla/"+null+"/comentario/"+comentario+"/nRevision/"+$("#nRevision").val()+"", function(response){

		});
		$("#comentarioParcial").val("");
	}else{		
		$.get("armadoRechazar/"+$("#piezaArmado").val()+"/inspector/"+$("#inspector").text()+"/etapa/"+idEtapa+"/comentario/"+$("#comentarioParcial").val()+"", function(response,state){
			$("#comentarioParcial").val("");
		});
		var comentario = "La pieza "+$("#piezaArmado option:selected").text()+" fue completamente rechazada";
		$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+null+"/falla/"+null+"/comentario/"+comentario+"/nRevision/"+$("#nRevision").val()+"", function(response){

		});
		$("#comentarioParcial").val("");
	}
});

$("#btnGuardarObservacion").click(function(){
	$("#formObservacion").hide()
	$("#btnAceptar").show();
	$("#errores").hide()
	if ($("#nombreArmador option:selected").length == 0){
		alert("Se debe seleccionar al menos un armador");
	}else{
		if (parseInt($("#errores tr").length) > 1) {
			$.get("crearPiezaOB/"+revision+"/consecutivo/"+1+"",function(response, state){
				$.get('armadoInsertaComentario/'+revision+'/revisionPlano/'+$("#nRevision").val()+'/comentario/'+$("#comentarioParcial").val()+'',function(){
					$("#comentarioParcial").val("");
				});
				consecutivo = consecutivo + 1;
				idPiezaOB = response;
			//guardar revision de plano y Comentario
			$.get("armadoCrearObservacion/"+idPiezaOB+"/inspector/"+inspector+"/revision/"+revision+"/armadorEstampa/"+$("#nombreArmador").val()+"/etapa/"+idEtapa+"",function(response, state){
				var comentario = "Se añade una observacion a la revision";
				$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+revision+"/observacion/"+response+"/falla/"+null+"/comentario/"+comentario+"/nRevision/"+$("#nRevision").val()+"", function(response){
					revision = 0;
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
		}else{
			var respuesta = confirm("La pieza no contiene fallas, sera contabilizada como pieza aprobada");
			if (respuesta) {
				nPieza = nPieza+1;
				$("#piezaActual").text(nPieza);
				$("#piezasAprobadas").val(parseInt($("#piezasAprobadas").val())+parseInt(1));
			}
		}
	}	
	/*regresar();*/
});

$("#guardarModificacion").click(function(event){
	$.get("armadoActualizaFalla/"+$("#idFalla").text()+"/tipoFalla/"+$("#tipoFallaM").val()+"/comentario/"+$("#comentarioM").val()+"/supervisor/"+$("#supervisorM").val()+"/indicacion/"+$("#indicacionM").val()+"/observacion/"+$("#observacionM").val()+"", function(response, state){
		var comentario = "Se actualizo la falla "+ $("#idFalla").text() +" de la observacion "+$("#piezaOB option:selected").text()+"";
		$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+$("#idFalla").text()+"/comentario/"+comentario+"/nRevision/"+$("#nRevision").val()+"", function(response){

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
				'background-color': ''
			});
		});
	});
});

$("#btnIgual").click(function(event){

	var comentario = "Termino la revision de la observacion "+$("#piezaOB option:selected").text()+" sin cambios";
	$.get("armadoCreaAccion/"+$("#inspector").text()+"/pieza/"+$("#piezaArmado").val()+"/etapa/"+idEtapa+"/revision/"+null+"/observacion/"+$("#piezaOB").val()+"/falla/"+null+"/comentario/"+comentario+"", function(response){
		actualizaCantidad();
		regresar();
	});
});
