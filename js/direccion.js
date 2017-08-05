//... ABRIR VENTANA DIALOG PARA DIRECCIONES...//
var URL = URLactual();

function direccion(obj,obj2){
	//$("#dialog-form").dialog("destroy"); //Destruir dialog para liberar recursos
	//obj.value='';
	$("#dialog-direccion").dialog({
		height: 450,
		width: 650,
		draggable:false,
		modal: true,
		open: function(){
			/*$('#dialog-direccion').html('');
			$.get(URL + 'php/direccion.php',function(data){
			$('#dialog-direccion').html(data);
			});*/
				$('#tDirCompleta').val('');
				$('#dialog-direccion select,#dialog-direccion input[type=text]').val('');
			    $('#uno').focus();
		},
		buttons: {
			'Crear direcci\u00F3n': function() {
			    obj.value=$('#tDirCompleta').val();
				$(this).dialog('close');
			}
		},
		close: function(evt, ui) {
			$('#tDirCompleta').val('');
			$('#dialog-direccion select,#dialog-direccion input[type=text]').val('');
			obj2.focus();
			$(this).dialog("destroy");
		}
	});
}//end function
//-- FIN DIRECCIONES	
