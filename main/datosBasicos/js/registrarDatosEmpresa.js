/*!
 * @autor:      Walther Rojas 
 * @fecha:      julio 25 de 2017
 * @objetivo: Gestionar Datos Empresa
 */
var ruta = "";
ruta = URLactual();
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
    Listar();
    $('#numeroIdentificacion').focusout(function() {
        var d = calcularDigitoVerificacion($(this).val());
        $('#txtDigito').val(d)
    })
    $('#btnGuardar').on('click', function() {
        if ($("form.datosEmpresa").validationEngine('validate')) {
            guardar()
            return false
        } else {
            return false
        }
    });

    function guardar() {
        var inputFileImage = document.getElementById("logo");
        var file = inputFileImage.files[0];
        var parametros = new FormData();
        parametros.append('logo', file)
        var url_logo = ""
        if (!file) url_logo = $('#logoImg').attr('src')
        parametros.append('url_logo', url_logo)
        parametros.append('nombre', $("#nombre").val())
        parametros.append('tipoDoc', $("#tipoIdentificacion").val())
        parametros.append('numIdent', $("#numeroIdentificacion").val())
        parametros.append('dv', $("#txtDigito").val())
        parametros.append('repre', $("#txtRepresentante").val())
        parametros.append('actividadEconomica', $("#actividadEconomica").val())
        parametros.append('direccion', $("#direccion").val())
        parametros.append('telefono', $("#txtTelefono").val())
        parametros.append('email', $("#email").val())
        parametros.append('dpto', $("#dpto").val())
        parametros.append('mpio', $("#mpio").val())
        parametros.append('sucursales', $("#sucursales").val())
        parametros.append('accion', "actualizar")
        console.log($("#txtRepresentante").val())
        $.ajax({
            url: "datosEmpresa.php",
            async: false,
            data: parametros,
            beforeSend: function(objeto) {
                dialogLoading('show');
            },
            complete: function(objeto, exito) {
                dialogLoading('close');
            },
            contentType: false,
            dataType: "html",
            error: function(objeto, quepaso, otroobj) {
                alertify.alert("Error! No se pudo reaizar la petición: " + otroobj);
            },
            global: true,
            ifModified: false,
            processData: false,
            cache: false,
            success: function(datos) {
                if (datos == 1) {
                    alertify.alert("Datos guardados correctamente", function() {
                    window.location = "../../main/index.php";
                    });
                } else {
                    alertify.alert(datos);
                }
            },
            timeout: 3000,
            type: "POST"
        });
    }
});
$('#logo').change(function(event) {
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $('#logoImg').attr('src', tmppath);
});

function Listar() {
    var parametros = {
        accion: "listar"
    };
    $.ajax({
        url: "datosEmpresa.php",
        async: false,
        data: parametros,
        beforeSend: function(objeto) {
            dialogLoading('show');
        },
        complete: function(objeto, exito) {
            dialogLoading('close');
        },
        contentType: "application/json",
        dataType: "json",
        error: function(objeto, quepaso, otroobj) {
            alertify.alert("Error! No se pudo realizar la petición: " + otroobj);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function(datos) {
            if (datos.length == 0) {
                $("#tipoIdentificacion").jCombo("../../util/definiciones.php?id=1");
                $("#actividadEconomica").jCombo("../../util/ciiu.php");
                $("#dpto").jCombo("../../util/deptos.php?id=1");
                $("#mpio").jCombo("../../util/ciudades.php?id=", {
                    parent: "#dpto"
                });
            }
            datos = datos[0];
            $("#tipoIdentificacion").jCombo("../../util/definiciones.php?id=1", {
                selected_value: datos.id_tipo_documento
            });
            $("#actividadEconomica").jCombo("../../util/ciiu.php", {
                selected_value: datos.id_actividad_economica
            });
            $("#dpto").jCombo("../../util/deptos.php?id=1", {
                selected_value: datos.cod_dpto
            });
            $("#nombre").val(datos.razon_social);
            $("#numeroIdentificacion").val(datos.numero_documento);
            $("#txtDigito").val(datos.digito);
            $("#txtRepresentante").val(datos.nom_represente);
            //$("#actividadEconomica").val(datos.id_actividad_economica);
            $("#direccion").val(datos.direccion);
            $("#txtTelefono").val(datos.telefono);
            $("#email").val(datos.email);
            $("#sucursales").val(datos.numero_sucursales);
            $("#mpio").jCombo("../../util/ciudades.php?id=", {
                parent: "#dpto",
                selected_value: datos.co_municipio
            });
            var ruta = urlLogo(datos.numero_documento) + datos.url_logo;
            //var ruta = "http://localhost/Empresas/" + datos.numero_documento + "/logo/" + datos.url_logo;
            $("#logoImg").attr('src', ruta);
        },
        timeout: 3000,
        type: "GET"
    });
}

function CheckFileName(fileName) {
    var ext = fileName.split('.').pop().toUpperCase();
    console.log(ext);
    if (ext == "PNG" || ext == "JPG" || ext == "JPEG" || ext == "GIF" || ext == "TIF") {
        return true;
    } else {
        return false;
    }
}

function calcularDigitoVerificacion(myNit) {
    var vpri,
        x,
        y,
        z;
    // Se limpia el Nit
    myNit = myNit.replace(/\s/g, ""); // Espacios
    myNit = myNit.replace(/,/g, ""); // Comas
    myNit = myNit.replace(/\./g, ""); // Puntos
    myNit = myNit.replace(/-/g, ""); // Guiones
    // Se valida el nit
    if (isNaN(myNit)) {
        console.log("El nit/cédula '" + myNit + "' no es válido(a).");
        return "";
    };
    // Procedimiento
    vpri = new Array(16);
    z = myNit.length;
    vpri[1] = 3;
    vpri[2] = 7;
    vpri[3] = 13;
    vpri[4] = 17;
    vpri[5] = 19;
    vpri[6] = 23;
    vpri[7] = 29;
    vpri[8] = 37;
    vpri[9] = 41;
    vpri[10] = 43;
    vpri[11] = 47;
    vpri[12] = 53;
    vpri[13] = 59;
    vpri[14] = 67;
    vpri[15] = 71;
    x = 0;
    y = 0;
    for (var i = 0; i < z; i++) {
        y = (myNit.substr(i, 1));
        // console.log ( y + "x" + vpri[z-i] + ":" ) ;
        x += (y * vpri[z - i]);
        // console.log ( x ) ;    
    }
    y = x % 11;
    // console.log ( y ) ;
    return (y > 1) ? 11 - y : y;
}