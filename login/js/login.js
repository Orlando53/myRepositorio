/*!
 * autor:       Orlando Puentes andrade
 * fecha:       julio 06 de 2017
 * objetivo:    archivo de gestion y validacion 
 */
/*
 variables publicas
*/
var ruta = "";
ruta = URLactual();
jQuery(document).ready(function() {
    $("#btnRegistrar").bind("click", function() {
        var strUsuario = $("#user").val();
        var strContrasena = $("#contrasena").val();
        if (strUsuario == "") return false;
        if (strContrasena == "") return false;
        var parametros = {
            "v0": strUsuario,
            "v1": strContrasena
        };
        logear(parametros);
    });
});

function logear(parametros) {
    $.ajax({
        url: "logear.php",
        async: false,
        data: parametros,
        beforeSend: function(objeto) {
            dialogLoading('show');
        },
        complete: function(objeto, exito) {
            dialogLoading('close');
        },
        contentType: "application/x-www-form-urlencoded",
        dataType: "json",
        error: function(objeto, quepaso, otroobj) {
            alertify.alert("Error en Login: " + otroobj);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function(datos) {
            switch (datos) {
                case -1:
                    alertify.alert("No se pudo establecer la conexión!");
                    break;
                case 0:
                    alertify.alert("Usuario o Contraseña errada!");
                    break;
                case 1:
                    abrirMenu('seguridad/cambiarContrasena.php'); //debe cambiar la contraseña
                    break;
                case 2:
                    alertify.alert("Información! Usuario Inactivo, debe ingresar a su correo electrónico para activar la cuenta");
                    break;
                    //gerente---------
                case 4:
                    abrirMenu('temporal/index.php'); //menu principal del gerente
                    break;
                case -4:
                    abrirMenu('index.php?ruta=main/index.php'); // pasos con los datso basicos de la empresa
                    break;
                case 04:
                    alertify.alert("Error al redireccionar al menú!");
                    break;
                    //empleado---------
                case 3:
                    abrirMenu('index.php?ruta=main/menuPrincipal.php'); //menu principal
                    break;
                case -3:
                    abrirMenu('index.php?ruta=main/datosBasicos/form-preguntas.html'); //hacer la encuesta
                    break;
            }
        },
        timeout: 3000,
        type: "GET"
    });
}

function abrirMenu(archivo) {
    var URL = ruta + archivo;
    window.open(URL, '_self');
}