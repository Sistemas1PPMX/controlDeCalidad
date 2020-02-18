$("#enviar").click(function(event){
	/*$(this).html('<a href="' + $.get('generarQR/'+$("#txtArea").val()+'') +'" download />');*/
	/*window.open('generarQR/'+$("#txtArea").val()+'', 'Download');
	$.get('generarQR/'+$("#txtArea").val()+'',function(response){
		console.log(response);
	});
	$("#imagen").attr('src', 'generarQR/'+$("#txtArea").val()+'');

	var a = document.createElement('a');
	a.href = 'generarQR/'+$("#txtArea").val()+'';
	a.download = $("#txtArea").val();
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);*/

	var linea = $("#txtArea").val().split("\n");
	console.log(linea);
	for (var i = 0; i < linea.length; i++) {
		var a = document.createElement('a');
		a.href = 'generarQR/'+linea[i]+'';
		a.download = linea[i];
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
	}

});