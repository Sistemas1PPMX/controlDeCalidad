var inspector;
$(document).ready(function(){
	$.get("regresaInspector/"+$("#supervisor").text()+"", function(response, state){
		$("#usuario").append(response[0].nombreUsuario);
		inspector = $("#supervisor").text();
	});

	$('#proyecto').selectpicker('reload');
	$('#pieza').selectpicker('reload');
	$.get('getProyectosPintura', function(response){
		console.log(response);
		$("#proyecto").empty();
		for (var i = 0; i < response.length; i++) {
			$("#proyecto").append('<option value="'+response[i].nombreProyecto+'">'+response[i].proyecto+'</option>');
		}
		$('#proyecto').selectpicker('refresh');		
	});
	//CASO ESPECIFICO TALARA
	$.get('getTalara',function(response){
		for (var i = 0; i < response.length; i++) {
			$("#proyecto").append('<option value="'+response[i].ContractID+'">'+response[i].Name+'</option>');
		}
		$('#proyecto').selectpicker('refresh');
	});
});

$("#proyecto").on('hidden.bs.select', function(event){
	$("#tabla tbody").empty();
	if ($("#proyecto option:selected").val() == 357 || $("#proyecto option:selected").val() == 359 || $("#proyecto option:selected").val() == 361 || $("#proyecto option:selected").val() == 363 || $("#proyecto option:selected").val() == 363 || $("#proyecto option:selected").val() == 364 || $("#proyecto option:selected").val() == 365 || $("#proyecto option:selected").val() == 369 || $("#proyecto option:selected").val() == 373) {
		$.get('pinturaCreaTalara/'+$("#proyecto").val()+"",function(response){
			$("#pieza").empty();
			for (var i = 0; i < response.length; i++) {
				if (response[i].consecutivo == null) {
					$("#pieza").append('<option value="'+response[i].idPieza+'">'+response[i].nombrePieza+'('+response[i].cantidad+')</option>');
				}else{
					$("#pieza").append('<option value="'+response[i].idPieza+'">'+response[i].nombrePieza+'-'+response[i].consecutivo+'('+response[i].cantidad+')</option>');
				}
			}
			$('#pieza').selectpicker('refresh');
		});
	}else{
		$.get('pinturaGetPiezas/'+$("#proyecto").val()+'', function(response){
			console.log(response);
			$("#pieza").empty();
			for (var i = 0; i < response.length; i++) {
				if (response[i].consecutivo == null) {
					$("#pieza").append('<option value="'+response[i].idPieza+'">'+response[i].nombrePieza+'('+response[i].cantidad+')</option>');
				}else{
					$("#pieza").append('<option value="'+response[i].idPieza+'">'+response[i].nombrePieza+'-'+response[i].consecutivo+'('+response[i].cantidad+')</option>');
				}
			}
			$('#pieza').selectpicker('refresh');
		});
	}

});

//CASO ESPECIFICO PINTURA


$("#pieza").on('hidden.bs.select', function(event){
	if ($("#pieza option:selected").text() != "--Placeholder--") {
		$("#tabla").append(''+
			'<tr><td name="'+$("#pieza").val()+'">'+$("#pieza option:selected").text().substring(0,$("#pieza option:selected").text().indexOf("("))+'</td>'+
			'<td><input class="form-control" type="number" value="'+$("#pieza option:selected").text().substring($("#pieza option:selected").text().indexOf("(")+1,$("#pieza option:selected").text().indexOf(")"))+'"></td>'+
			'<td><input type="checkbox" style="width: 20%;"></td>'+
			'<td><input type="button" class="btn btn-danger btn-block" value="Eliminar"></td></tr>'+
			'');
		$("#pieza option:selected").remove();
		if ($("#pieza").find('option').length == parseInt(0)) {
			$("#pieza").append("<option>--Placeholder--</option>");
		}
		$("#pieza").selectpicker('refresh');
	}
});

$("#guardar").click(function(event){
	var muestra = false;
	$("#tabla").find('input[type="checkbox"]').each(function(){
		if ($(this).is(':checked')) {
			muestra = true;
			return false;
		}else{
			muestra = false;
		}
	});
	if (muestra == true) {
		if ($("#lote").val() != "") {
			$.get('creaLotePintura/'+inspector+'/lote/'+$("#lote").val()+'', function(response){
				var lote = response;
				var conjunto = 1;
				$("#tabla tr:not(:first)").each(function(){
					var arreglo = [];
					arreglo.push($(this).find('td:eq(0)').attr('name'));
					arreglo.push($(this).find('input[type="number"]').val());
					arreglo.push($(this).find('input[type="checkbox"]').is(':checked'));
					$.get('agregaPiezaLote/'+lote+'/pieza/'+arreglo[0]+'/cantidad/'+arreglo[1]+'/muestra/'+arreglo[2]+'/conjunto/'+($(this).closest('tr').index()+1)+'', function(){
						conjunto = conjunto+1;
					});	
					console.log(conjunto);
				});
				$("#lote").val("");
				$("#tabla tbody").empty();
			});
		}else{
			alert("No se ha ingresado un codigo para el lote");
		}
	}else{
		alert("No se ha selecionado ningun elemento para muestra");
	}
});

$("#tabla").on('click', 'input[type="button"]', function(event){
	console. log($(this).closest('tr').find('td').eq(1).find('input[type="number"]').val());
	$("#pieza").append("<option name='"+$(this).closest('tr').find('td').eq(0).attr('name')+"'>"+$(this).closest('tr').find('td').eq(0).text()+"("+$(this).closest('tr').find('td').eq(1).find('input[type="number"]').val()+")</option>");
	$("#pieza").find('option:contains("--Placeholder--")').remove();
	$("#pieza").selectpicker('refresh');
	$(this).closest('tr').remove();
});