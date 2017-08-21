/*
 * @autor: Juan Diego Ninco Collazos
 * @fecha: 2017-28-07
 * @objetivo: reenviar correos
 */

var ruta = "";
ruta = URLactual();

$('#btn_terminar').click(function() {
    alertify.confirm("¿Quieres terminar este paso y entrar al menú principal?", function(e) {
        if (e) {
            var parametros = {
                paso: 'paso6'
            };
            $.ajax({
                url: "actualizarPasos.php",
                async: false,
                type: "POST",
                data: parametros,
                beforeSend: function() {
                    dialogLoading('show');
                },
                complete: function() {
                    dialogLoading('close');
                },
                success: function(data) {
                	var URL = ruta + "index.php";
                	window.open(URL, '_top','status=no');
                }
            });
        }
    });
});
$('#btn_reenviar').click(function() {
    var values = new Array();
    $("input[name='usuarios[]']:checked").each(function() {
        values.push($(this).attr('id'));
    });
    seleccionado = ($('[name="usuarios[]"]:checked').length);
    if (seleccionado == 0) {
        alertify.alert("Error! Debe seleccionar minimo un registro para reenviar el correo");
    } else {
        alertify.confirm('¿Seguro que desea reenviar el correo electrónico?', function(e) {
            if (e) {
                $.ajax({
                    type: "POST",
                    url: './datosUsuario.php',
                    dataType: "json",
                    async: false,
                    data: {
                        ids_persona: values,
                        accion: 'reenviarCorreo'
                    },
                    beforeSend: function() {
                        dialogLoading('show');
                    },
                    complete: function() {
                        dialogLoading('close');
                    },
                    success: function(data) {
                        switch (data) {
                            case 1:
                                alertify.alert('Bien! Se han reenviado los correos electrónicos a los usuarios seleccionados', function() {
                                    window.location = "./respuestaEncuesta.php";
                                });
                                break;
                            case 0:
                                alertify.alert('Información! No se han podido reenviar todos los correos electrónicos seleccionados', function() {
                                    window.location = "./respuestaEncuesta.php";
                                });
                                break;
                        }
                    }
                });
            }
        });
    }
});