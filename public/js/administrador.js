$(document).ready(function(){
	$("#contenedor").append("Que onda que px");
});

$("#btnUsuarios").click(function(event){
	$.get("usuariosCrud", function(response){
		$("#contenedor").empty();
		$("#contenedor").append(response);
	});
});

$("#btnPiezas").click(function(event){
	$.get("piezasCrud", function(response){
		$("#contenedor").empty();
		$("#contenedor").append(response);
	});
});

$("#btnFallas").click(function(event){
	$.get("fallasCrud", function(response){
		$("#contenedor").empty();
		$("#contenedor").append(response);
	});
});	

