$(document).ready(function(){
	$.get('areas', function(response, state){
		for (var i = 0; i<response.length; i++) {
			$("#area").append('<option value="'+response[i].idEtapa+'">'+response[i].descripcionEtapa+'</option>');
		}
	})
});

$("#btnEnviar").click(function(event){
	if ($("#nombre").val() != "" && $("#descripcion").val() != "") {
		$.get('guardaBug/'+$("#nombre").val()+'/modulo/'+$("#area").val()+'/descripcion/'+$("#descripcion").val()+'',function(response, state){
			alert("El numero de falla es el "+response);
			limpiar();
		});
	}
});

function limpiar(){
	$("#nombre").val("");
	$("#descripcion").val("");

}