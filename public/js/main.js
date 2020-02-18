var flag=0;

$(document).ready(function(){

/*	var respuesta = confirm("Se ha liberado una nueva version del programa. ¿Instalar?");
	if (respuesta == true) {
		window.location.href = "/updateAPK";
	}else{

	}*/

	/*alert("Version Alpha v0.0.4: Se añadio modululo de Armado y Soldadura");*/

	$('#nip').keyPad({
		template : '#tpl-keypad',
		isRandom: false,
		valueAttr: 'keyVal',
		template: false,
		container: 'body',
		cmd: 'cmd'
	});

	$(document).on("wheel", "input[type=password]", function (e) {
		$(this).blur();
	});
	
	$(":input[type=password]").on('keypress', function(e){
		var keyCode = (event.keyCode ? event.keyCode : event.which);
		if(keyCode == '13'){
			document.blur();
		}
	});
	
	$(":input[type=password]").on('keypress', function(e){
		return e.metaKey || // cmd/ctrl
		e.which <= 0 || // arrow keys
		e.which == 8 || // delete key
		/[0-9]/.test(String.fromCharCode(e.which)); // numbers
	});
});

$("#btnLogin").click(function(event){
	window.location.href = "/login";
});

$("#btnRegister").click(function(event){
	window.location.href = "/register";
});

$("#btnRegistrase").click(function(event){
	validacion();
	$.get("nuevoUsuario/"+$("#nombre").val()+"/apellidoP/"+$("#apellidoP").val()+"/apellidoM/"+$("#apellidoM").val()+"/nip/"+$("#nip").val()+"", function(response, state){
		limpiaFormulario();
		window.location.href = "/";
	});
});

$("#btnLogout").click(function(event){
	window.location.href = "logout";
});

$("#nip").change(function(event){
	alert();
});

function validacion(){
	if ($("#nombre").val() == "") {
		$("#fdbNombre").text("El nombre no puede estar vacio");
		$("#nombre").addClass('is-invalid');
		$("#nombre").val("")
		flag = 0;
	}else{
		$("#nombre").removeClass('is-invalid')
		flag = 1;
	}
	if ($("#apellidoP").val() == "") {
		$("#fdbApellidoP").text("El apellido paterno no puede estar vacio");
		$("#apellidoP").addClass('is-invalid');
		$("#apellidoP").val("")
		flag =0;
	}else{
		$("#apellidoP").removeClass('is-invalid')
		flag = 1;
	}
	if ($("#apellidoM").val() == "") {
		$("#fdbApellidoM").text("El apellido materno no puede estar vacio");
		$("#apellidoM").addClass('is-invalid');
		$("#apellidoM").val("")
		flas = 0;
	}else{
		$("#apellidoM").removeClass('is-invalid')
		flag = 1;
	}
	if (parseInt($("#nip").val().length) < parseInt(4)) {
		$("#fdbNip").text("El nip debe ser un valir numerico de 4 digitos");
		$("#nip").addClass('is-invalid');
		$("#nip").val("")
		flag = 0;
	}else{
		if (parseInt($("#nip").val().length) > parseInt(4)) {
			$("#fdbNip").text("El nip debe ser un valir numerico de 4 digitos");
			$("#nip").addClass('is-invalid');
			$("#nip").val("")
			flag = 0;
		}else{
			$("#nip").removeClass('is-invalid')
			flag = 1;
		}
	}
}

function limpiaFormulario(){
	$("#nombre").val("");
	$("#apellidoP").val("");
	$("#apellidoM").val("");
	$("#nip").val("");
}