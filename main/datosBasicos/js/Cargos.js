/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-24-07
 * @objetivo: CRUD cargos
 */
function actualizar() {
    window.location = "../datosBasicos/registrarCargos.php";
}

function contarFilas() {
    var table = $('#tabla').DataTable();
    var numeroRegistros = table.column(0).data().length;
    return numeroRegistros;
}
$('#btn-guardarCargos').click(function() {
    if ($("#frmCargos").validationEngine("validate")) {
        var url = "guardarCargos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmCargos").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 1) {
                    alertify.alert("Bien! Cargo registrado correctamente", function() {
                        window.location = "../datosBasicos/registrarCargos.php";
                    });
                } else {
                    alertify.alert("Error! El cargo que intenta agregar ya se encuentra registrado");
                }
            }
        });
    }
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
$(document).ready(function() {
    $("#selJefe").jCombo("../../util/cargarCargosCombo.php?estado=1", {
        first_optval: "0",
        initial_text: "Ninguno"
    });
    // $("#selReporta").jCombo("../../util/cargarCargosCombo.php?estado=1", {
    //     first_optval: "0",
    //     initial_text: "Ninguno"
    // });
    $("#selJefeAct").jCombo("../../util/cargarCargosCombo.php?estado=1", {
        first_optval: "0",
        initial_text: "Ninguno"
    });
    // $("#selReportaAct").jCombo("../../util/cargarCargosCombo.php?estado=1", {
    //     first_optval: "0",
    //     initial_text: "Ninguno"
    // });
});

function validar() {
    var retorno;
    //var id_check = $('input:checkbox[name=IdsCargos]:checked').val();
    seleccionados = ($('[name="IdsCargos[]"]:checked').length);
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

function eliminarRegistros() {
    alertify.confirm("¿Está seguro que quiere eliminar el registro seleccionado ?", function(e) {
        if (e) {
            var url = "eliminarCargos.php";
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
                    window.location = "../datosBasicos/registrarCargos.php";
                }
            });
        } else {
            window.location = "../datosBasicos/registrarCargos.php";
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
        var url = "actualizarCargos.php";
        var id_check = $("input:checked").attr("value");
        //var id_check = $('input:checkbox[name=IdsCargos]:checked').val();
        var parametros = {
            id_cargo: id_check
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
                var cargo = data[0];
                $('#txtNombreAct').val(cargo.cargo);
                $('#id_cargo').val(cargo.id_cargo);
                if (cargo.id_jefe_inmediato == 0) {
                    $("#selJefeAct").jCombo("../../util/cargarCargosCombo.php?estado=1", {
                        first_optval: "0",
                        initial_text: "Ninguno",
                        selected_value: cargo.id_cargo
                    });
                } else {
                    $("#selJefeAct").jCombo("../../util/cargarCargosCombo.php?estado=1", {
                        first_optval: "0",
                        initial_text: "Ninguno",
                        selected_value: cargo.id_jefe_inmediato
                    });
                }
                $('#txtDescripcionAct').val(cargo.descripcion);
                $('#actualizarModal').modal('show');
            }
        });
    }
});
$('#btn-actualizarCargos').click(function() {
    if ($("#frmActualizarCargo").validationEngine("validate")) {
        var url = "confirmarActualizacionCargos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmActualizarCargo").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 1) {
                    alertify.alert("Bien! Cargo actualizado", function() {
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
        alertify.alert("Error! No ha registrado cargos, debe registrar al menos uno");
    } else {
        alertify.confirm("¿Quiere continuar con el siguiente paso?", function(e) {
            if (e) {
                var parametros = {
                    paso: 'paso3'
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
        });
    }
});