$(document).ready(function(){
	$("#formObservacion").hide();
	$.get('getLotePintura', function(response){
		console.log(response);
		$("#lote").empty();
		for (var i = 0; i < response.length; i++) {
			$("#lote").append("<option value='"+response[i].idLotePintura+"'>"+response[i].codigoLote+"</option>");
		}
		$.get('getPiezasPintura/'+$("#lote").val()+'/etapa/pinturaPrep', function(response){
			console.log(response);
			tabla(response);
		});
	});

	$.get("regresaSupervisores", function(response, state){
		for(var i = 0; i<response.length; i++){
			$("#sqi").append("<option value='"+response[i].idSupervisor+"'>"+response[i].nombreSupervisor+" "+response[i].apellidoPsupervisor+" "+response[i].apellidoMsupervisor+"</option>");
		}
	});

	$("#indicacion").append("<option value='Reprocesar'>Reprocesar</option>");
	$("#indicacion").append("<option value='Reparar'>Reparar</option>");
	$("#indicacion").append("<option value='Usar como está'>Usar como está</option>");
	$("#indicacion").append("<option value='Scrap'>Scrap</option>");

	$.get("defectos", function(response){
		$("#defecto").empty();
		for(i = 0; i < response.length; i++){
			$("#defecto").append("<option value='"+response[i].idTipoFalla+"'> "+response[i].descripcionTipoFalla+"</option>");
		}
		$("#defecto").selectpicker('reload');
		$("#tipoFallaM").selectpicker('reload');
		$("#defecto").selectpicker('refresh');
		$("#tipoFallaM").selectpicker('refresh');
	});
});

function tabla(arreglo){
	$("#tabla tr:not(:first)").empty();
	for (var i = 0; i < arreglo.length; i++) {
		var identificador
		if (arreglo[i].consecutivo == null) {
			identificador=arreglo[i].idConjunto
		}else{
			identificador = arreglo[i].consecutivo
		}
		$("#tabla").append("<tr><td value='"+arreglo[i].idPieza+"''>"+arreglo[i].nombrePieza+"-"+identificador+"</td><td>"+arreglo[i].cantidad+"</td><td>"+arreglo[i].descripcionStatus+"</td><td><input type='button' class='btn btn-success btn-block' name='aceptar' value='Aceptar'></input></td><td><input type='button' name='observacion' class='btn btn-danger btn-block' value='Observacion'></input></td></tr>");
	}
}
$("#lote").change(function(event){
	$.get('getPiezasPintura/'+$("#lote").val()+'/etapa/'+$("#etapa").val()+'', function(response){
		console.log(response);
		tabla(response);
	});
});

$("#etapa").change(function(event){
	$.get('getPiezasPintura/'+$("#lote").val()+'/etapa/'+$("#etapa").val()+'', function(response){
		console.log(response);
		tabla(response);
	});
});

$("#tabla").on('click', 'input[name="aceptar"]', function(event){
	var cantidad = parseInt($(this).closest('tr').find('td').eq(1).text()); 
	if (cantidad > 1) {
		var pieza = $(this).closest('tr').find('td').eq(0).attr('value')
		var conjunto = $(this).closest('tr').find('td').eq(0).text().substring($(this).closest('tr').find('td').eq(0).text().indexOf('-')+1,$(this).closest('tr').find('td').eq(0).text().length);
		console.log(conjunto);
		$.get('apruebaPiezaPinturaM/'+pieza+'/conjunto/'+conjunto+'/etapa/'+$("#etapa").val()+'', function(){
		});
		$(this).closest('tr').remove();
	}else{
		var pieza = $(this).closest('tr').find('td').eq(0).attr('value')
		var conjunto = $(this).closest('tr').find('td').eq(0).text().substring($(this).closest('tr').find('td').eq(0).text().indexOf('-')+1,$(this).closest('tr').find('td').eq(0).text().length);
		console.log(conjunto);
		$.get('apruebaPiezaPinturaE/'+pieza+'/consecutivo/'+conjunto+'/etapa/'+$("#etapa").val()+'', function(){
		});
		$(this).closest('tr').remove();
	}
});

$("#tabla").on('click', 'input[name="observacion"]', function(event){
	$("#lblLote").text($("#lote").val());
	$("#lblPieza").text($(this).closest('tr').find('td').eq(0).attr('value'));
	$.get('getPiezasReemplazar/'+$("#lote").val()+'', function(response){
		$("#muestra").empty();
		for (var i = 0; i < response.length; i++) {
			$("#muestra").append("<option value='"+response[i].idPiezaPintura+"'>"+response[i].nombrePieza+"-"+response[i].consecutivo+"</option>");
		}
	});
	$("#modalObservacion").modal('show');
});

$("#btnOb").on('click', function(event){
	if (revisar()) {
		$("#tablaOb").append("<tr><td>"+$("#defecto").val()+"</td><td>"+$("#descripcion").val()+"</td><td>"+$("#sqi").val()+"</td><td>"+$("#indicacion").val()+"</td><td>"+$("#observaciones").val()+"</td><td><input type='button' class='btn btn-danger btn-block' value='eliminarFalla'></td></tr>");
		vaciar();
	}else{
		alert('La observacion no puede contener campos vacios');
	}
});

$("#tablaOb").on('click', 'input[type="button"]', function(event){
	$(this).closest('tr').remove();
});

$("#btnGuardar").click(function(event){
	var arreglo = [];
	var observacion
	$.get('pinturaCrearOB/'+$("#lblLote").text()+'/pieza/'+$("#lblPieza").text()+'/supervisor/'+$("#supervisor").text()+'', function(response){
		observacion =response;
		$("#tablaOb").find('tr:not(:first)').each(function(){
			$(this).children().each(function(){
				arreglo.push($(this).text());
			});
			$.get('pinturaCreaFalla/'+observacion+'/idTipoFalla/'+arreglo[0]+'/comentario/'+arreglo[1]+'/supervisor/'+arreglo[2]+'/indicacion/'+arreglo[3]+'/observacion/'+arreglo[4]+'', function(response){
				console.log(response);
			});
			console.log(arreglo);
			arreglo = [];
		});
		$.get('reemplazarPieza/'+$("#lblPieza").text()+'/piezaFinal/'+$("#muestra").val()+'', function(){
			$.get('getPiezasPintura/'+$("#lote").val()+'/etapa/'+$("#etapa").val()+'', function(response){
				console.log(response);
				tabla(response);
			});
		});
		$("#tablaOb tr:not(:first)").empty();
		$("#modalObservacion").modal('hide');
	});
});

$("#tabla").on('click', 'input[id="observacionG"]' ,function(event){
	$("#modalObservacion").modal('show');
	
});

function vaciar(){
	$("#defectos").val("");
	$("#descripcion").val("");
	$("#observaciones").val("");
}

function revisar(){
	if ($("#defectos").val()=="") {
		return false;
	}else if($("#descripcion").val()==""){
		return false;
	}else if($("#sqi").val()== ""){
		return false;
	}else if($("#indicacion").val()==""){
		return false();
	}else if ($("#observaciones").val() == "") {
		return false
	}else{
		return true;
	}
}
