/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-07
 * @objetivo: Registro Inicial de Empresa
 */

var URL = "";
URL = URLactual();

$(document).ready(function() {
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
            guardar();
        } 
    });
    $("#tipoIdentificacion").jCombo("../../util/definiciones.php?id=1");

 function guardar() {
	 $.ajax({
            type: "POST",
            async: false,
            url: "datosInicialesEmpresa.php",
            data: $("#datosEmpresa").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
               if (data == 1) {
                    alerta("Se envió un mensaje al correo ingresado");
                    var url = "http://localhost/portalweb/index.php";
                    window.open(url,"_self");
                }else{
                	alerta(data);
                }
            }
        });
    }
});