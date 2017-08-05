/*!
 * autor:		Jhonatan Fernando Martínez
 * fecha:		julio 14 de 2017
 * objetivo: 	Efectos Visuales de esta Vista 
 */

$('#logo').on('change', function (event) {
    var inputFileImage = document.getElementById("logo");
    if(CheckFileName(inputFileImage.value)== false){
        alert("Archivo no valido")
	$(this).val('');
        return 
    }
    var file = inputFileImage.files[0];
    var size = file.size / 1024
    if (size > 2000) {
	$(this).val('');
        alert('El tamaño del archivo no debe ser mayor a 2 MB')
        return
    }
    var reader = new FileReader();
    var urlBase64;
    // Os esperábais algo más complicado?
    reader.onload = function () {
        urlBase64 = reader.result;
        $('#logoImg').attr('src', urlBase64)
    }
    reader.readAsDataURL(file);
    $(this).siblings('label').text($(this).val().split('\\').pop());
})
