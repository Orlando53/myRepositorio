$(document).ready(function() {
    $('#txtNombre1').focus();
    $("#selTipoDocumento").jCombo("../../util/definiciones.php?id=1");
    $("#selJefe").jCombo("../../util/jefeInmediato.php?estado=1");
    $("#selCargo").jCombo("../../util/cargarCargosCombo.php?estado=1");
    $("#selArea").jCombo("../../util/areasTrabajo.php?estado=1");
    $("#selRol").jCombo("../../util/roles.php");
    $("#selSede").jCombo("../../util/sedes.php");
    $('.selectpicker').selectpicker('render');
    $('.selectpicker').selectpicker('refresh');
});
$('#fileFoto').change(function(event) {
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $('#foto').attr('src', tmppath);
});
$('#fileFirma').change(function(event) {
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $('#firma').attr('src', tmppath);
});
$('#btnGuardarUsuario').click(function() {
    if ($("form.datosEmpresa").validationEngine('validate')) {
        var inputFoto = document.getElementById("fileFoto");
        var inputFirma = document.getElementById("fileFirma");
        data = new FormData();
        data.append('primerNombre', $('#txtNombre1').val());
        data.append('segundoNombre', $('#txtNombre2').val());
        data.append('primerApellido', $('#txtApellido1').val());
        data.append('segundoApellido', $('#txtApellido2').val());
        data.append('tipoDocumento', $('#selTipoDocumento').val());
        data.append('numeroDocumento', $('#numDocumento').val());
        data.append('correoElectronico', $('#email').val());
        data.append('foto', inputFoto.files[0]);
        data.append('firma', inputFirma.files[0]);
        data.append('cargo', $('#selCargo').val());
        data.append('area', $('#selArea').val());
        data.append('jefeInmediato', $('#selJefe').val());
        data.append('sucursal', $('#selSede').val());
        data.append('img_foto', $('#foto').attr('src'));
        data.append('img_firma', $('#firma').attr('src'));
        data.append('accion', accion_usuario);
        if (accion_usuario == 'update') {
            data.append('id_persona', $("input:checked").attr("id"));
        }
        $.ajax({
            url: "./datosUsuario.php",
            async: false,
            data: data,
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            contentType: false,
            dataType: "json",
            error: function(objeto, quepaso, otroobj) {
                alertify.alert('Error! Nol se pudo realizar petición: ' + otroobj);
            },
            global: true,
            ifModified: false,
            processData: false,
            cache: false,
            success: function(datos) {
                switch (datos) {
                    case -1:
                        alertify.alert('Error! No se pudo establecer la conexión', function() {
                            window.location = "usuarios.php";
                        });
                        break;
                    case 1:
                        $('#insertarModal').modal('hide');
                        alertify.alert('Bien! Datos guardados correctamente, el usuario registrado debe verificar su correo electrónico en Recibidos o Spam', function() {
                            window.location = "usuarios.php";
                        });
                        break;
                    case 0:
                        alertify.alert('Error! No se guardaron los datos, intenta guardarlos nuevamente');
                        break;
                    case -2:
                        alertify.alert('Información! Se guardaron los datos correctamente pero ha fallado el envio de correo electrónico para la activación de la cuenta, verifica el registro');
                        break;
                    case 3:
                        $('#insertarModal').modal('hide');
                        alertify.alert('Bien! Registro actualizado correctamente', function() {
                            window.location = "usuarios.php";
                        });
                        break;
                    case -3:
                        alertify.alert('Error! No se actualizo del registro, intenta guardarlos nuevamente');
                        break;
                    case -5:
                        alertify.alert('Error! El correo electronico ingresado ya se encuentra registrado');
                        break;
                }
            },
            timeout: 3000,
            type: "POST"
        });
    } else {
        return false;
    }
});