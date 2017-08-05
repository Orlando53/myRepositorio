/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-07
 * @objetivo: CRUD sucursales
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
    $("#tipoIdentificacion").jCombo("../../util/definiciones.php?id=1");
    $("#selDPTO").jCombo("../../util/deptos.php?id=1");
    $("#selMPIO").jCombo("../../util/ciudades.php?id=", {
        parent: "#selDPTO"
    });
    //Listar();
    // $('#numeroIdentificacion').focusout(function() {
    //     var d = calcularDigitoVerificacion($(this).val());
    //     $('#txtDigito').val(d)
    // })
    $('#btn-guardarSucursal').on('click', function() {
        if ($("form.frmDatosSucursal").validationEngine('validate')) {
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
        parametros.append('prefijo', $("#Prefijo").val())
        parametros.append('nombre', $("#nombre").val())
        parametros.append('tipoDoc', $("#tipoIdentificacion").val())
        parametros.append('numIdent', $("#numeroIdentificacion").val())
        parametros.append('telefono', $("#numTelefono").val())
        parametros.append('direccion', $("#direccion").val())
        parametros.append('email', $("#email").val())
        parametros.append('dpto', $("#selDPTO").val())
        parametros.append('mpio', $("#selMPIO").val())
        $.ajax({
            url: "guardarSucursales.php",
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
                //alertify.alert(datos);
                if (datos == 1) {
                    alertify.alert("Bien! Datos guardados correctamente", function() {
                        window.location = "../datosBasicos/registrarSucursales.php";
                    });
                    //return false;
                } else {
                    alertify.alert("Error! No se guaradron los datos");
                }
            },
            timeout: 3000,
            type: "POST"
        });
    }
});
//----------------------------------------------------------------//
//----------------------------------------------------------------//
//----------------------------------------------------------------//
function actualizar() {
    window.location = "../datosBasicos/registrarSucursales.php";
}

function contarFilas() {
    var table = $('#tabla').DataTable();
    var numeroRegistros = table.column(0).data().length;
    return numeroRegistros;
}

function marcar(source) {
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
        }
    }
}
$('#logo').change(function(event) {
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $('#logoImg').attr('src', tmppath);
});
$('#btnEliminar').click(function() {
    var estado;
    estado = validar();
    if (estado == 0) {
        alertify.alert('Error! Debe seleccionar al menos un ítem');
    } else if (estado == 1) {
        eliminarRegistros();
    } else {
        eliminarRegistros();
    }
});

function validar() {
    var retorno;
    //var id_check = $('input:checkbox[name=IdsCargos]:checked').val();
    seleccionados = ($('[name="IdsSucursales[]"]:checked').length);
    if (seleccionados != 0) {
        if (seleccionados != 1) {
            retorno = 1;
        } else {
            retorno = 2;
        }
    } else {
        retorno = 0;
    }
    return retorno;
}

function eliminarRegistros() {
    alertify.confirm("¿Está seguro que quiere eliminar el registro seleccionado ?", function(e) {
        if (e) {
            var url = "eliminarSucursales.php";
            $.ajax({
                type: "POST",
                url: url,
                data: $("#frmOperaciones").serialize(),
                beforeSend: function() {
                    dialogLoading('show');
                },
                complete: function() {
                    dialogLoading('close');
                },
                success: function(data) {
                    if (data == 1) {
                        alertify.alert("Bien! Cargo eliminado");
                    }
                    window.location = "../datosBasicos/registrarSucursales.php";
                }
            });
        } else {
            window.location = "../datosBasicos/registrarSucursales.php";
        }
    });
}
$('#btnModificar').click(function() {
    var estado;
    estado = validar();
    if (estado == 0) {
        alertify.alert("Error! Debe seleccionar un ítem");
    } else if (estado == 1) {
        alertify.alert("Error! Debe seleccionar solo un ítem por operación");
    } else {
        var url = "actualizarSucursales.php";
        var id_check = $("input:checked").attr("value");
        //var id_check = $('input:checkbox[name=IdsCargos]:checked').val();
        var parametros = {
            id_sucursal: id_check
        };
        $.ajax({
            type: "POST",
            url: url,
            data: parametros,
            dataType: 'json',
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                var sucursal = data[0];
                $('#PrefijoAct').val(sucursal.prefijo);
                $('#idSucursal').val(sucursal.id_sucursal);
                $('#nombreAct').val(sucursal.razon_social);
                $("#tipoIdentificacionAct").jCombo("../../util/definiciones.php?id=1", {
                    first_optval: "0",
                    initial_text: "Ninguno",
                    selected_value: sucursal.id_tipo_documento
                });
                $('#numeroIdentificacionAct').val(sucursal.numero_documento);
                $('#logoAct').val(sucursal.url_logo);
                $('#numTelefonoAct').val(sucursal.telefono);
                $('#direccionAct').val(sucursal.direccion);
                $('#emailAct').val(sucursal.email);
                $("#selDPTOAct").jCombo("../../util/deptos.php?id=1", {
                    first_optval: "0",
                    initial_text: "Ninguno",
                    selected_value: sucursal.cod_dpto
                });
                $("#selMPIOAct").jCombo("../../util/ciudades.php?id=1", {
                    first_optval: "0",
                    initial_text: "Ninguno",
                    selected_value: sucursal.co_municipio
                });
                $('#actualizarModal').modal('show');
            }
        });
    }
});
$('#btn-actualizarSucursal').click(function() {
    if ($("#frmActualizarSucursal").validationEngine("validate")) {
        var url = "confirmarActualizacionSucursal.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmActualizarSucursal").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 1) {
                    alertify.alert("Bien! Sucursal actualizada", function() {
                        window.location = "../datosBasicos/registrarCargos.php";
                    });
                }
                //$('#actualizarModal').modal('show');
                //$('#respuesta').append(data);
            }
        });
    }
});
$('#imgCheck').click(function() {
    if (contarFilas() == 0) {
        alertify.alert("No ha registrado sucursales, debe registrar al menos una");
    } else {
        alertify.confirm("¿Quiere continuar con el siguiente paso?", function(e) {
            if (e) {
                var parametros = {
                    paso: 'paso4'
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
                        window.location = "../../main/index.php";
                    }
                });
            }
        })
    }
});