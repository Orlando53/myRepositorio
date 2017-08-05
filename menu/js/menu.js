/*
* @autor:		orlando puentes andrade	
* @fecha:		julio 13 de 2017
* @objetivo:	gestios menu
*/

var ruta = "";		
var recurso;
var modalObj;
ruta = URLactual();
 
 jQuery(document).ready(function(){
	modalObj = $("#div-superior");
 	imp_menu("superior");
 	modalObj = $("#div-iz_arriba");
 	imp_menu("iz_arriba");

 });

 function imp_menu(ubicacion){
 	recurso = $("#txtRecurso").val();

 	var parametros = {"v1":ubicacion};
 	$.ajax({
			url: 	"traerMenu.php",
			async: 	false,
			data:	parametros,
			beforeSend: function(objeto){
				//dialogLoading('show');
			},
			complete: function(objeto, exito){
				//dialogLoading('close');
				if(exito == "success"){
            	
				}
			},
			contentType: "application/x-www-form-urlencoded",
			dataType: "json",
			error: function(objeto, quepaso, otroobj){
				alert("Error en traerMenu: "+otroobj);
			},
			global: true,
			ifModified: false,
			processData:true,
			success: function(datos){
				modalObj.empty();
				modalObj.html(datos);
				$.each(datos,function(i,fila){
					var cad = fila.menu;
					modalObj.append(" -- " + cad + " -- ");
				});
			},
				
			timeout: 3000,
			type: "GET",
			encoding:"UTF-8"
		});
 }