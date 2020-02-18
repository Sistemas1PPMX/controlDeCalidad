<!DOCTYPE html>
<html>
<head>
	<title>Generador QR</title>
</head>
<body>
	<textarea id="txtArea" style="width: 50vw; height: 15vh;"></textarea>
	<button id="enviar">GENERAR QR</button>
	<img src="" id="imagen">

	{!! Html::script('js\jquery-3.4.1.min.js') !!}
	{!! Html::script('js\QR.js') !!}

</body>
</html>