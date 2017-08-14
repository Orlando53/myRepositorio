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
});

function guardar() {
	$.ajax({
		url: "datosInicialesEmpresa.php",
        async:false,
        data: $("#datosEmpresa").serialize(),
        beforeSend: function(objeto){
        	dialogLoading('show');
        },
        complete: function(objeto, exito){
        	dialogLoading('close');
            if(exito == "success"){
            	$( "#tabs" ).tabs( "option", "active", 2 );
            }
        },
        contentType: "application/x-www-form-urlencoded",
        dataType: "json",
        error: function(objeto, quepaso, otroobj){
            alert("En Registar Empresa, pasó lo siguiente: "+otroobj);
        },
        global: true,
        ifModified: false,
        processData:true,
        success: function(data) {
            if (data == 1) {
                 alerta("Se envio un correo a su email");
                 var url = "http://localhost/portalweb/index.php";
                 window.open(url,"_self");
             }else{
             	alert(data);
             }
         },
        timeout: 3000,
        type: "GET"
	})
	
}
	
	