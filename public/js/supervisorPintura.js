var numero = 1;
var lote;
$(document).ready(function() {
	$('select').selectpicker();
	$('select').selectpicker('render');

	$.get("supervisorPinturaGetPiezasCYP", function(response, state){
		for (var i = 0; i < response.length; i++) {
			$("#pieza").append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
		}
		$.get("supervisorPinturaGetPiezasSoldadura", function(response, state){
			for (var i = 0; i < response.length; i++) {
				$("#pieza").append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
			}
			$("#pieza").selectpicker('refresh');
		});
	});
});

$("#btnLogout").click(function(event){
	window.location.href = "logout";
});

$("#pieza").on('change.bs.select', function(event){
	var markup = "<tr><td id='id'>"+numero+"</td><td id='nombre'>"+$("#pieza option:selected").text()+"</td><td><input type='button' value='ELIMINAR'>";
	$("#tabla").append(markup);
	$("#pieza option:selected").remove();
	$("#pieza").selectpicker('refresh');
	sortTable();
	numero++;
});

$("#tabla").on('click', 'input[type="button"]', function(e){
	$("#pieza").append("<option>"+$(this).closest('tr').find("td[id='nombre']").text()+"</option>");
	$("#pieza").selectpicker('refresh');
	numero = $(this).closest('tr').find("td[id='id']").text();
	$(this).closest('tr').remove()
});

$("#btnGuardar").on('click', function(event){
	if ($("#lote").val() == "") {
		alert("no se puede crear un lote sin numero");
	}else {
		if($("#tabla tr").length <= 1){
			alert("el lote no contiene ninguna pieza");
		}else{
			$.get("creaLotePintura/"+$("#lote").val()+"/supervisor/"+$("#supervisor").text()+"", function(response, state){
				lote = parseInt(response);
				$("#tabla > tr").each(function(){
					var valor;
					valor = $(this).find("td[id='nombre']").text();
					$.get("asignaPiezaPintura/"+valor+"/lote/"+lote+"", function(response, state){
						console.log(response);
					});
				});
			});
		}	
	} 
	/*$("#errores tr:not(:first)").remove();*/
});

function sortTable() {
	var table, rows, switching, i, x, y, shouldSwitch;
	table = document.getElementById("tabla");
	switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
    }
}
if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
  }
}
}