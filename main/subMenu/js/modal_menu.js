/*
 * @autor:      Juan Diego Ninco Collazos
 * @fecha:      julio 19 de 2017
 * @objetivo:   acciones para mostrar perfil y cambiar contraseña
 */
var_titulo = $("#titulo_modal_menu");
var_contenido = $("#contenido_modal_menu");
alerta_modal = $("#alerta_modal");

function contenido_modal(titulo, ruta_archivo) {
    $.ajax({
        url: ruta_archivo,
        async: false,
        beforeSend: function(objeto) {
            $.blockUI({
                message: '<h1><img src="../../../media/image/ajaxload.gif"></h1>'
            });
        },
        complete: function() {
            $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        },
        error: function() {
            var_contenido.html('Error al traer contenido!');
        },
        success: function(datos) {
            var_titulo.text(titulo);
            var_contenido.html(datos);
        },
        timeout: 3000,
        type: "GET",
        encoding: "UTF-8"
    });
}

function cambiar_clave() {
    if ($("#cambioContrasena").validationEngine('validate')) {
        clave_actual = $('#contrasenaActual');
        clave_nueva = $('#contrasenaNueva');
        confirmar_clave = $('#contrasenaConfirmada');
        if (clave_nueva.val() != confirmar_clave.val()) {
            alert('La contraseña nueva no coincide con la de confirmación!');
            clave_nueva.val('');
            confirmar_clave.val('');
        } else {
            parametros = {
                clave_actual: clave_actual.val(),
                clave_nueva: clave_nueva.val()
            }
            $.ajax({
                url: './main/subMenu/actualizarContrasena.php',
                async: false,
                data: parametros,
                beforeSend: function(objeto) {
                    $.blockUI({
                        message: '<h1><img src="../../../media/image/ajaxload.gif"></h1>'
                    });
                },
                complete: function() {
                    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
                },
                contentType: false,
                dataType: "json",
                error: function(objeto, quepaso, otroobj) {
                    alert('Error al realizar petición: ' + otroobj);
                },
                global: true,
                ifModified: false,
                processData: true,
                success: function(datos) {
                    switch (datos) {
                        case -1:
                            alert('Error! No se ha podido establecer la conexión');
                            break;
                        case 1:
                            alert('La contraseña se ha actualizado exitosamente, debe iniciar sesión nuevamente!');
                            clave_actual.val('');
                            clave_nueva.val('');
                            confirmar_clave.val('');
                            window.location = "./main/subMenu/cerrarSession.php";
                            break;
                        case 0:
                            alert('Error!  La contraseña actual no es correcta!');
                            clave_actual: clave_actual.val();
                            break;
                    }
                },
                timeout: 3000,
                type: "GET",
                encoding: "UTF-8"
            });
        }
    } else {
        return false;
    }
}