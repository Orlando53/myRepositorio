$('#btnConfirmar').click(function() {
    if ($("#cambioContrasena").validationEngine('validate')) {
        usuario = $('#usuario');
        clave_actual = $('#contrasenaActual');
        clave_nueva = $('#contrasenaNueva');
        confirmar_clave = $('#contrasenaConfirmada');
        if (clave_nueva.val() != confirmar_clave.val()) {
            alertify.alert('Error! la contraseña nueva no coincide con la de confirmación');
            clave_nueva.val('');
            confirmar_clave.val('');
        } else {
            parametros = {
                usuario: usuario.val(),
                clave_actual: clave_actual.val(),
                clave_nueva: clave_nueva.val()
            }
            $.ajax({
                url: '../seguridad/actualizarContrasena.php',
                async: false,
                data: parametros,
                beforeSend: function(objeto) {
                    dialogLoading('show');
                },
                complete: function() {
                    dialogLoading('close');
                },
                contentType: false,
                dataType: "json",
                error: function(objeto, quepaso, otroobj) {
                    alertify.alert('Error! No se ha realizado la petición: ' + otroobj);
                },
                global: true,
                ifModified: false,
                processData: true,
                success: function(datos) {
                    switch (datos) {
                        case -1:
                            alertify.alert('Error! No se ha podido establecer la conexión');
                            break;
                        case 1:
                            alertify.alert('Bien! La contraseña ha sido actualizada correctamente, ingrese con su nueva contraseña!', function() {
                                window.location = "../login";
                            });
                            break;
                        case 0:
                            alertify.alert('Error! Usuario o Contraseña errada');
                            clave_actual.val("");
                            usuario.val("");
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
});