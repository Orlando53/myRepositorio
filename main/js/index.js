/*!
 * autor:       Walther Rojas 
 * fecha:       julio 25 de 2017
 * objetivo:     
 */
$(document).ready(function() {
	$('a').each(function() {
	    $(this).data('href', $(this).attr('href')).removeAttr('href');
	});
	$('a').on('click', function() {
	    window.location.href = $(this).data('href');
	});
    $.ajax({
        url: "controlPasos.php",
        async: false,
        beforeSend: function(objeto) {
            dialogLoading('show');
        },
        complete: function(objeto, exito) {
            dialogLoading('close');
        },
        contentType: false,
        dataType: "json",
        error: function(objeto, quepaso, otroobj) {
            alert("En Contacto hay un error: " + otroobj);
        },
        global: true,
        ifModified: false,
        processData: false,
        cache: false,
        success: function(datos) {
            var control = datos[0];
            if (control.paso1 == 0) {
                $('#div-paso1').addClass('active')
            } else if (control.paso2 == 0) {
                $('#div-paso2').addClass('active')
            } else if (control.paso3 == 0) {
                $('#div-paso3').addClass('active')
            } else if (control.paso4 == 0) {
                $('#div-paso4').addClass('active')
            } else if (control.paso5 == 0) {
                $('#div-paso5').addClass('active')
            } else if (control.paso6 == 0) {
                $('#div-paso6').addClass('active')
            } else if (control.paso7 == 0) {
                $('#div-paso7').addClass('active')
            }
        },
        timeout: 3000,
        type: "POST"
    });
})