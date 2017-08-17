var count = 1;
function crearCampo(){
	var tipo = $('#tipo option:selected').text();
	var nombre = $('#nombre').val();
	var salida = 0;		
	if(nombre==0){
		alert("Asigna un Nombre");
	}
	else{
		switch(tipo){
			case "Texto":
				$('#forms').append('<div class="form-group third"><label for="campo'+count+'">'+nombre+'</label><input type="text" name="campo'+count+'" id="campo'+count+'" class="form-control" placeholder="'+nombre+'"></div>');
				count++;
				alert("el campo "+tipo+", de nombre "+nombre+" fue creado");
				$('#createform')[0].reset();
				$('#modal').modal('toggle');
				break;
			case "Número": 
				$('#forms').append('<div class="form-group third"><label for="campo'+count+'">'+nombre+'</label><input type="number" name="campo'+count+'" id="campo'+count+'" class="form-control" placeholder="'+nombre+'"></div>');
				count++;
				alert("el campo "+tipo+", de nombre "+nombre+" fue creado");
				$('#createform')[0].reset();
				$('#modal').modal('toggle');
				break;
			case "Fecha":
				$('#forms').append('<div class="form-group third"><label for="campo'+count+'">'+nombre+'</label><input type="date" name="campo'+count+'" id="campo'+count+'" class="form-control" placeholder="'+nombre+'"></div>');
				count++;
				alert("el campo "+tipo+", de nombre "+nombre+" fue creado");
				$('#createform')[0].reset();
				$('#modal').modal('toggle');
				break;
			case "Select": alert("seleccionaste Select");
				break;
			case "TextArea":
				$('#forms').append('<div class="form-group full"><label for="campo'+count+'">'+nombre+'</label><textarea id="campo'+count+'" class="form-control"></textarea><p class="charcount"></p></div>');
				count++;
				alert("el campo "+tipo+", de nombre "+nombre+" fue creado");
				$('#createform')[0].reset();
				$('#modal').modal('toggle');
				break;
			case "Archivo":
				$('#forms').append('<div class="file-input"><label for="campo'+count+'">'+nombre+'</label><input type="file" name="campo'+count+'" id="campo'+count+'"></div>');
				count++;
				alert("el campo "+tipo+", de nombre "+nombre+" fue creado");
				$('#createform')[0].reset();
				$('#modal').modal('toggle');
				break;
			default: alert("por favor Selecciona Algo");
		}	
	}		
}