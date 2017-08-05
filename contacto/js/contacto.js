var ruta = "";
//ruta = URLactual();

$(document).ready(function () {
    //$('#mail').popover('show');
    $('.container form').submit(function () {
        var parametros = {
            empresa: $("#empresa").val(),
            nombre: $("#nombre").val(),
            cargo: $("#cargo").val(),
            email: $("#mail").val(),
            telefono: $("#telefono").val(),
            ciudad: $("#ciudad").val(),
            mensaje: $("#mensaje").val()
        };
        $.ajax({
            url: "contacto.php",
            async: false,
            data: parametros,
            beforeSend: function (objeto) {
                $.blockUI({
                    message: '<h1><img src="../media/image/ajaxload.gif"></h1>'
                });
            },
            complete: function (objeto, exito) {
                $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            },
            contentType: "application/x-www-form-urlencoded",
            dataType: "text",
            error: function (objeto, quepaso, otroobj) {
                alert("En Contacto hay un error: " + otroobj);
            },
            global: true,
            ifModified: false,
            processData: true,
            success: function (datos) {
                if (datos == 1) {
                    alert("Su mensaje fué enviado. En unos momentos le estaremos dando respuesta!");
                    enviarCorreo(parametros.email, parametros.nombre, parametros.mensaje,"Acaba de llegar un correo de un contacto");
                } else {
                    alert("Ocurrió un error al intentar enviar este mensaje, por favor intente mas tarde!");
                }


            },
            timeout: 3000,
            type: "GET"
        });
    });


    $("#mail").focusout(function () {
        if (validarEmail(this)) {
//            alert("ok");
        } else {
            $(this).focus();
//            alert("mal");
        }
    });
});

function validarEmail(campo) {
    var regex = new RegExp(/[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/);
    if (regex.test($(campo).val())) {
        return true;
    } else {
        return false;
    }
}

function enviarCorreo(correo, nombre, mensaje,asunto) {
    var parametros = {
        email: correo,
        nombre: nombre,
        mensaje: mensaje,
        asunto: asunto
    };
    $.ajax({
        url: "../util/email/envio.php",
        async: false,
        data: parametros,
        beforeSend: function (objeto) {
            $.blockUI({
                    message: '<h1><img src="../media/image/ajaxload.gif"></h1>'
                });
        },
        complete: function (objeto, exito) {
            $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        },
        contentType: "application/x-www-form-urlencoded",
        dataType: "text",
        error: function (objeto, quepaso, otroobj) {
            alert("En Contacto hay un error: " + otroobj);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function (datos) {
            
        },
        timeout: 3000,
        type: "GET"
    });
}