/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: CRUD áreas de trabajo
 */
function actualizar() {
    window.location = "../datosBasicos/registrarAreasTrabajo.php";
}

function contarFilas() {
    var table = $('#tabla').DataTable();
    var numeroRegistros = table.column(0).data().length;
    return numeroRegistros;
}

function eliminarRegistros() {
    alertify.confirm("¿Está seguro que quiere eliminar el registro seleccionado ?", function(e) {
        if (e) {
            var url = "eliminarAreasTrabajo.php";
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
                        alertify.alert("Bien! Área eliminada", function() {
                            window.location = "../datosBasicos/registrarAreasTrabajo.php";
                        });
                    }
                    
                }
            });
        } else {
            window.location = "../datosBasicos/registrarAreasTrabajo.php";
        }
    });
    // if (confirmar("¿Está seguro que quiere eliminar el registro seleccionado ?") == true) {
    //     var url = "eliminarAreasTrabajo.php";
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: $("#frmOperaciones").serialize(),
    //         beforeSend: function() {
    //             dialogLoading('show');
    //         },
    //         complete: function() {
    //             dialogLoading('close');
    //         },
    //         success: function(data) {
    //             if (data == 1) {
    //                 alerta("Área eliminada");
    //             }
    //             window.location = "../datosBasicos/registrarAreasTrabajo.php";
    //         }
    //     });
    // } else {
    //     window.location = "../datosBasicos/registrarAreasTrabajo.php";
    // }
}
//Marca los checkboxes de la tabla, desde el checkbox de arriba
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
//Valida para eliminar y modificar
function validar() {
    var retorno;
    seleccionados = ($('[name="IdsAreas[]"]:checked').length);
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
//Habilita o inhabilita botones de acuerdo a si hay o no datos en la tabla
//$(document).ready(function() {
// for (var i = 0; i < document.getElementById('tabla').rows.length - 1; i++) {}
// if (i == 0) {
//     document.getElementById('btnEliminar').disabled = true;
//     document.getElementById('btnModificar').disabled = true;
//     document.getElementById('btnVer').disabled = true;
//     document.getElementById('btnExportar').disabled = true;
// } else {
//     document.getElementById('btnEliminar').disabled = false;
//     document.getElementById('btnModificar').disabled = false;
//     document.getElementById('btnVer').disabled = true;
//     document.getElementById('btnExportar').disabled = true;
// }
//});
//Filtra los datos mostrados por página en la tabla
// function filtroTabla() {
//     // Variables 
//     var input, filter, table, tr, td, i;
//     input = document.getElementById("search");
//     filter = input.value.toUpperCase();
//     table = document.getElementById("tabla");
//     tr = table.getElementsByTagName("tr");
//     //Hace un loop a través de las filas de la tabla y oculata aquellas que no correspondan a la consulta.
//     for (i = 0; i < tr.length; i++) {
//         td = tr[i].getElementsByTagName("td")[1]; //1 para buscar por Nombre
//         if (td) {
//             if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
//                 tr[i].style.display = "";
//             } else {
//                 tr[i].style.display = "none";
//             }
//         }
//     }
// }
$('#btn-guardarAreasTrabajo').click(function() {
    if ($("#frmAreasTrabajo").validationEngine("validate")) {
        var url = "guardarAreasTrabajo.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmAreasTrabajo").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 1) {
                    alertify.alert("Bien! Área registrada", function() {
                        window.location = "../datosBasicos/registrarAreasTrabajo.php";
                    });
                } else {
                    alertify.alert("Información! El área de trabajo que intenta agregar ya se encuentra registrada");
                }
            }
        });
    }
});
$('#btnEliminar').click(function() {
    var estado;
    estado = validar();
    if (estado == 0) {
        alertify.alert("Error! Debe seleccionar al menos un ítem");
    } else if (estado == 1) {
        eliminarRegistros();
    } else {
        eliminarRegistros();
    }
});
$('#btnModificar').click(function() {
    var estado;
    estado = validar();
    if (estado == 0) {
        alertify.alert("Error! Debe seleccionar un ítem");
    } else if (estado == 1) {
        alertify.alert("Error! Debe seleccionar solo un ítem por operación");
    } else {
        var url = "actualizarAreasTrabajo.php";
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
                $('#actualizarModal').modal('show');
                $('#respuesta').append(data);
                //window.location = "../datosBasicos/registrarAreasTrabajo.php";
            }
        });
    }
});
$('#btn-actualizarAreasTrabajo').click(function() {
    if ($("#frmActualizarArea").validationEngine("validate")) {
        var url = "confirmarActualizacionAreas.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmActualizarArea").serialize(),
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            success: function(data) {
                if (data == 1) {
                    alertify.alert("Bien! Área actualizada", function() {
                        window.location = "../datosBasicos/registrarAreasTrabajo.php";
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
        alertify.alert("Error! No ha registrado áreas de trabajo, debe registrar al menos una");
    } else {
        alertify.confirm("¿Quiere continuar con el siguiente paso?", function(e) {
            if (e) {
                var parametros = {
                    paso: 'paso2'
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
            } else {
                actualizar();
            }
        });
    }
});