$(document).ready(function(){
	$.get("regresaUsuarios", function(response){
		console.log(response);

		for (var i = 0; i < response.length; i++) {
			if (response[i].permisos ==1) {
				response[i].permisos = "ADMINISTRADOR";
			}else if(response[i].permisos ==2){
				response[i].permisos = "INSPECTOR";
			}else if(response[i].permisos == 3){
				response[i].permisos = "SUPERVISOR";
			}
			$("#tabla").append("<tr><td>"+(i+1)+"</td><td>"+(response[i].nombreUsuario+" "+response[i].apellidoPaterno+" "+response[i].apellidoMaterno)+"</td><td>"+response[i].permisos+"</td><td><input type='button' id='editar' class='btn btn-primary' value='Editar' style='width: 50%;'><input type='button' id='editar' class='btn btn-danger' value='Eliminar' style='width: 50%;'></td></tr>");
		}
	});
});