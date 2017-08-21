/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-07
 * @objetivo: Registro Inicial de Empresa
 */
var URL = "";
URL = URLactual();
$(document).ready(function() {
    //alertify.alert(window.location.hostname + '/portalweb/index.php');
    $('#direccion').on('focus', function() {
        $("#div-direccion").load('../../util/direccion.php');
        var arr = [];
        $('#div-direccion select,#div-direccion input:text').bind("blur", function() {
            var indice = parseInt($(this).attr('tabindex')) - 1;
            arr[indice] = $(this).val();
            $('#tDirCompleta').val('');
            $.each(arr, function(i, n) {
                if (n != undefined) {
                    var esp = (i == 9) ? '-' : ' ';
                    $('#tDirCompleta').val($.trim($('#tDirCompleta').val() + esp + n.toUpperCase()));
                }
            });
            //alert("Posicion "+indice+"= "+arr[indice]);
        });
        $("#modalDireccion").modal();
        $("#btnAceptar-dir").bind("click", function() {
            $('#direccion').val($('#tDirCompleta').val());
        });
    })
    $('#btnEnviarDatosEmpresa').on('click', function() {
        if ($("form.datosEmpresa").validationEngine('validate')) {
            guardar()
            return false
        } else {
            return false
        }
    });
    $("#tipoIdentificacion").jCombo("../../util/definiciones.php?id=1");
    $("#tipoIdentificacionRl").jCombo("../../util/definiciones.php?id=1");

    function guardar() {
        var url = "datosInicialesEmpresa.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#datosEmpresa").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 0) {
                    alertify.alert(data);
                } else {
                    alertify.alert("En un nomento nos pondremos en contacto!", function() {
                        window.open('http://192.168.1.10/portalweb/', "_top");
                    });
                }
            }
        });
    }
});