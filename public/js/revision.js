var id;
$(document).ready(function(){
	$.get("/getValues", function(response){
		id = response;
	});
	$.get('http://192.168.4.212/getStatus',function(response){
		console.log(response);
		for (var i = 0; i < response.length; i++) {
			$("#pieza").append("<option value='"+response[i].etiquetaViajera+"'>"+response[i].etiquetaViajera+"</option>")
		}
		for (var i = 1; i <= 50; i++) {
			$("#estacion").append("<option value='"+i+"'>"+i+"</option>");
		}
		$("select").selectpicker('reload');
		$("select").selectpicker('refresh');
	});
});

$("#btnIniciar").click(function(e){
	$.get("http://192.168.4.212/inspeccion/"+id+"/proceso/"+4+"/pieza/"+$("#pieza").val()+"/estacion/"+$("#estacion").val()+"", function(response){
		console.log(response);
	});
});

