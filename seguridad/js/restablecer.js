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
        success: function(data) {
            //$('#success').html(data);
            //$( "#respuesta" ).append(data);
            if (confirm(data) == true) {
                window.location = "../../index.php";
            } else {
                //window.location="../login/index.html";
            }
        }
    });
});