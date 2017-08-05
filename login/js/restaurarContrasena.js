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
            $("#respuesta").html('<img src="../media/image/ajaxload.gif" />');
        },
        success: function(data) {
            $("#respuesta").html(data);
        }
    });
});