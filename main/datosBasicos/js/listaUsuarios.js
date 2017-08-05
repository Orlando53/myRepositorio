$(document).ready(function() {
    $("#search").focus();
});
$('#btn_insertar').click(function() {
    accion_usuario = 'insert';
    $.ajax({
        type: "POST",
        url: './formularioUsuario.php',
        beforeSend: function() {
            dialogLoading('show');
        },
        complete: function() {
            dialogLoading('close');
        },
        success: function(data) {
            $('#contenedor').html(data);
        }
    });
    $('#insertarModal').modal('show');
});
$('#btn_modificar').click(function() {
    seleccionado = ($('[name="usuarios[]"]:checked').length);
    accion_usuario = 'update';
    if (seleccionado == 0) {
        alertify.alert("Error! Debe seleccionar un registro para modificar");
    } else {
        if (seleccionado > 1) {
            alertify.alert('Error! Solo puede seleccionar un registro')
        } else {
            $('#insertarModal').modal('show');
            id_persona = $("input:checked").attr("id");
            $('#pFormularioUsuario').text('Actualizar datos de usuario');
            $.ajax({
                type: "POST",
                url: './formularioUsuario.php',
                beforeSend: function() {
                    dialogLoading('show');
                },
                complete: function() {
                    dialogLoading('close');
                },
                success: function(data) {
                    $('#contenedor').html(data);
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: './datosUsuario.php',
                        data: {
                            id_persona: id_persona,
                            accion: 'consultarRegistro'
                        },
                        beforeSend: function() {
                            dialogLoading('show');
                        },
                        complete: function() {
                            dialogLoading('close');
                        },
                        success: function(data) {
                            var datos = data[0];
                            $('#txtNombre1').val(datos.primer_nombre);
                            $('#txtNombre2').val(datos.segundo_nombre);
                            $('#txtApellido1').val(datos.primer_apellido);
                            $('#txtApellido2').val(datos.segundo_apellido);
                            $('#selTipoDocumento').val();
                            $('#numDocumento').val(datos.numero_documento);
                            $('#txtFechaExpedicion').val(datos.fecha_expedicion_documento);
                            $('#email').val(datos.email);
                            $('#foto').attr('src', datos.url_foto);
                            $('#firma').attr('src', datos.url_firma);
                            $("#selCargo").jCombo("../../util/cargarCargosCombo.php?estado=1", {
                                selected_value: datos.id_cargo
                            });
                            $("#selArea").jCombo("../../util/areasTrabajo.php?estado=1", {
                                selected_value: datos.id_area_trabajo
                            });
                            $("#selJefe").jCombo("../../util/jefeInmediato.php?estado=1", {
                                selected_value: datos.id_persona_jefe
                            });
                            $("#selTipoDocumento").jCombo("../../util/definiciones.php?id=1", {
                                selected_value: datos.id_tipo_documento
                            });
                            $("#selSede").jCombo("../../util/sedes.php", {
                                selected_value: datos.id_sucursal
                            });
                        }
                    });
                }
            });
        }
    }
});
$('#btn_eliminar').click(function() {
    seleccionado = ($('[name="usuarios[]"]:checked').length);
    if (seleccionado == 0) {
        alertify.alert("Error! Debe seleccionar un registro para eliminar");
    } else {
        if (seleccionado > 1) {
            alertify.alert('Error! Solo puede seleccionar un registro');
        } else {
            alertify.confirm('¿Seguro que desea eliminar el registro?', function(e) {
                if (e) {
                    $.ajax({
                        type: "POST",
                        url: './datosUsuario.php',
                        data: {
                            id_persona: $("input:checked").attr("id"),
                            accion: 'eliminarRegistro'
                        },
                        beforeSend: function() {
                            dialogLoading('show');
                        },
                        complete: function() {
                            dialogLoading('close');
                        },
                        success: function(data) {
                            alertify.alert('Bien! Registro eliminado correctamente', function() {
                                window.location = "./usuarios.php";
                            });
                        }
                    });
                }
            });
        }
    }
});

function contarFilas() {
    var table = $('#tabla').DataTable();
    var numeroRegistros = table.column(0).data().length;
    return numeroRegistros;
}
$('#imgCheck').click(function() {
    if (contarFilas() == 0) {
        alertify.alert("Error! Debe haber al menos un registro para continuar");
    } else {
        alertify.confirm("¿Quiere continuar con el siguiente paso?", function(e) {
            if (e) {
                var parametros = {
                    paso: 'paso5'
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