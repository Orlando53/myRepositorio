/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Restaurar Contraseña
 */
$('#btn-restaurar').click(function() {
    var url = "../seguridad/validaremail.php";
    $.ajax({
        type: "POST",
        url: url,
        data: $("#frmRestablecer").serialize(),
        beforeSend: function() {
            dialogLoading('show');
        },
        complete: function() {
            dialogLoading('close');
        },
        success: function(data) {
            if (data == 0) {
                alertify.confirm("El mensaje no pudo ser enviado", function(e) {
                    if (e) {
                        window.location = "../index.php";
                    } else {
                        return false;
                    }
                });
            }
            if (data == 1) {
                alertify.confirm("El mensaje ha sido enviado al correo electrónico ingresado, por favor revise la bandeja de entrada o de Spam", function(e) {
                    if (e) {
                        window.location = "../index.php";
                    } else {
                        return false;
                    }
                });
            }
            if (data == 2) {
                alertify.confirm("Ya realizó una petición de reestablecimiento de contraseña, por favor revise su bandeja de entrada o la carpeta Spam", function(e) {
                    if (e) {
                        window.location = "../index.php";
                    } else {
                        return false;
                    }
                });
            }
            if (data == 3) {
                alertify.confirm("No existe una cuenta asociada al correo electrónico ingresado", function(e) {
                    if (e) {
                        window.location = "../index.php";
                    } else {
                        return false;
                    }
                });
            }
            if (data == 4) {
                alertify.confirm("Debe introducir el correo electrónico de la cuenta", function(e) {
                    if (e) {
                        window.location = "../index.php";
                    } else {
                        return false;
                    }
                });
            }
        }
    });
});