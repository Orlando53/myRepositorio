/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Restablecer contraseña
 */
$('#btnRegistrar').click(function() {
    var url = "cambiarpassword.php";
    $.ajax({
        type: "POST",
        url: url,
        data: $("#frmCambiarPassword").serialize(),
        beforeSend: function() {
            dialogLoading('show');
        },
        complete: function() {
            dialogLoading('close');
        },
        success: function(data) {
            //$('#success').html(data);
            //$( "#respuesta" ).append(data);
            if (data == 0) {
                alertify.alert("Ocurrió un error al actualizar la contraseña, intentalo más tarde");
            }
            if (data == 1) {
                alertify.confirm("La contraseña ha sido actualizada. Será re direccionado a la página de inicio", function(e) {
                    if (e) {
                        window.location = "../../../portalweb/index.php";
                    } else {
                        return false;
                    }
                });
            }
            if (data == 2) {
                alertify.alert("Las contraseñas no coinciden o la contraseña ingresada está actualmente en uso");
            }
            if (data == 3) {
                alertify.alert("El token no es válido");
            }
        }
    });
});