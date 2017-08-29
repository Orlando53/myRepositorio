/*
 * @autor:Jose Luis Perdomo Andrade
 * @fecha;2017-13-07
 * @objetivo: Ver y responder inquietudes
 */
var ruta = "";
ruta = URLactual();
var fileBase64 = "";
var fileName = "";
$(document).ready(function() {
    $('#myModalVer').on('show.bs.modal', function() {});
    $('#myModalVer').on('hide.bs.modal', function() {
        $(".tdEmpresa").text("");
        $(".tdNombre").text("");
        $(".tdEmail").text("");
        $(".tdMensaje").text("");
        $(".tdCargo").text("");
        $(".tdTelefono").text("");
        $(".hdnIdContacto").val("");
        $(".hdnEmail").val("");
    });
    $('#myModalAcciones').on('show.bs.modal', function() {});
    $('#myModalAcciones').on('hide.bs.modal', function() {
        $(".sltAccionAdd").val("");
        $(".txtaDescAdd").val("");
        $(".hdnIdAccion").val("");
        $(".sltAccionEdit").val("");
        $(".txtaDescEdit").val("");
        $(".tdEmpresa").text("");
        $(".tdNombre").text("");
        $(".tdEmail").text("");
        $(".tdMensaje").text("");
        $(".tdCargo").text("");
        $(".tdTelefono").text("");
        $(".hdnIdContacto").val("");
        $(".hdnEmail").val("");
        var estado = $("#slEstado").val()
        traerMensajes("", estado);
    });
    $("#slEstado").val("R");
    traerMensajes("", $("#slEstado").val(), 'inicio');
    $(document).on("click", ".btnResponder", function() {
        $(".tdEmpresa").text($(this).attr("data-empresa"));
        $(".tdNombre").text($(this).attr("data-nombre"));
        $(".tdEmail").text($(this).attr("data-email"));
        $(".tdCargo").text($(this).attr("data-cargo"));
        $(".tdTelefono").text($(this).attr("data-telefono"));
        $(".hdnIdContacto").val($(this).attr("data-id"));
        $(".hdnEmail").val($(this).attr("data-email"));
        $(".acciones").html("");
        var acciones = "";
        var url = "respuestaContacto.php?_=" + new Date().getTime();
        var type = "GET";
        var dataType = "JSON";
        var parametros = {
            tarea: "mensaje_accion",
            id_mensaje_contacto: $(this).attr("data-idMensaje")
        };
        peticion(url, parametros, type, dataType, function(datos) {
            if (datos.error.length <= 0) {
                if (datos.result.length > 0) {
                    acciones = ListarAccione(datos.result)
                    $(".acciones").html(acciones);
                }
            }
        });
        if ($(this).text() == "Ver") {
            $(".txtaMensajeVer").val($(this).attr("data-mensaje"));
            $('#myModalVer').modal("show");
        } else if ($(this).text() == "Acciones") {
            $('#myModalAcciones').modal("show");
        }
    });
    $("#slEstado").change(function() {
        traerMensajes($('#txtBuscar').val(), $(this).val());
    });
    $("#txtBuscar").keyup(function(e) {
        traerMensajes($(this).val(), $("#slEstado").val());
    });
    $('.sltAccionAdd').change(function() {
        $(".txtaDescAdd").val("");
    })
    $(".btnAddAccion").click(function() {
        $(".sltAccionAddError").text("");
        $(".sltAccionAddError").hide();
        $(".txtaDescAddError").text("");
        $(".txtaDescAddError").hide();
        if ($(".sltAccionAdd").val().length <= 0) {
            $(".sltAccionAddError").text("Por favor seleccione una acción");
            $(".sltAccionAddError").show();
            $(".sltAccionAdd").focus();
            return;
        }
        if ($(".txtaDescAdd").val().trim().length <= 0) {
            $(".txtaDescAddError").text("Por favor escriba una descripción");
            $(".txtaDescAddError").show();
            $(".txtaDescAdd").focus();
            return;
        }
        var url = "respuestaContacto.php?_=" + new Date().getTime();
        var accion = $(".sltAccionAdd").val()
        var mensaje = $(".txtaDescAdd").val()
        var parametros = {
            tarea: "add_mensaje_accion",
            id_mensaje_contacto: $(".hdnIdContacto").val(),
            accion: accion,
            email: $('.tdEmail').html(),
            nombre: $('.tdNombre').html(),
            mensaje: mensaje,
            fileName: fileName,
            fileBase64: fileBase64,
        };
        var type = "GET";
        var dataType = "TEXT";
        peticion(url, parametros, type, dataType, function(datos) {
            if (datos == "1") {
                var acciones = "";
                var url = "respuestaContacto.php?_=" + new Date().getTime();
                var type = "GET";
                var dataType = "JSON";
                var parametros = {
                    tarea: "mensaje_accion",
                    id_mensaje_contacto: $(".hdnIdContacto").val()
                };
                peticion(url, parametros, type, dataType, function(datos) {
                    if (datos.error.length <= 0) {
                        if (datos.result.length > 0) {
                            acciones = ListarAccione(datos.result)
                            $(".acciones").html(acciones);
                            $(".sltAccionAdd").val("");
                            $(".txtaDescAdd").val("");
                        }
                    } else alert(datos.error)
                });
            } else {
                alert('No se pudo ejecutar la acción!')
            }
        });
    });
    $(document).on("click", ".editAccion", function() {
        $(".hdnIdAccion").val($(this).attr("data-id"));
        $(".sltAccionEdit").val($(this).attr("data-accion"));
        $(".txtaDescEdit").val($(this).attr("data-descripcion"));
    });
    $(".btnEditAccion").click(function() {
        $(".sltAccionEditError").text("");
        $(".sltAccionEditError").hide();
        $(".txtaDescEditError").text("");
        $(".txtaDescEditError").hide();
        if ($(".txtaDescEdit").val().trim().length <= 0) {
            $(".txtaDescEditError").text("Por favor escriba una descripción");
            $(".txtaDescEditError").show();
            $(".txtaDescEdit").focus();
            return;
        }
        var url = "respuestaContacto.php?_=" + new Date().getTime();
        var parametros = {
            tarea: "edit_mensaje_accion",
            id_accion_mensaje_contacto: $(".hdnIdAccion").val(),
            descripcion: $(".txtaDescEdit").val(),
        };
        var type = "GET";
        var dataType = "TEXT";
        peticion(url, parametros, type, dataType, function(datos) {
            if (datos == "1") {
                var acciones = "";
                var url = "respuestaContacto.php?_=" + new Date().getTime();
                var type = "GET";
                var dataType = "JSON";
                var parametros = {
                    tarea: "mensaje_accion",
                    id_mensaje_contacto: $(".hdnIdContacto").val()
                };
                peticion(url, parametros, type, dataType, function(datos) {
                    if (datos.error.length <= 0) {
                        if (datos.result.length > 0) {
                            acciones = ListarAccione(datos.result)
                            $(".acciones").html(acciones);
                            $(".hdnIdAccion").val("");
                            $(".sltAccionEdit").val("");
                            $(".txtaDescEdit").val("");
                        }
                    }
                });
            }
        });
    });
    $(".btnRmAccion").click(function() {
        if ($(".hdnIdAccion").val().length <= 0) {
            alert("Debe seleccionar la acción a eliminar");
            return;
        }
        if (confirm("Esta seguro de eliminar esta acción")) {
            var url = "respuestaContacto.php?_=" + new Date().getTime();
            var parametros = {
                tarea: "rm_mensaje_accion",
                id_accion_mensaje_contacto: $(".hdnIdAccion").val()
            };
            var type = "GET";
            var dataType = "TEXT";
            peticion(url, parametros, type, dataType, function(datos) {
                if (datos == "1") {
                    var acciones = "";
                    var url = "respuestaContacto.php?_=" + new Date().getTime();
                    var type = "GET";
                    var dataType = "JSON";
                    var parametros = {
                        tarea: "mensaje_accion",
                        id_mensaje_contacto: $(".hdnIdContacto").val()
                    };
                    peticion(url, parametros, type, dataType, function(datos) {
                        if (datos.error.length <= 0) {
                            if (datos.result.length > 0) {
                                acciones = ListarAccione(datos.result)
                                $(".acciones").html(acciones);
                                $(".hdnIdAccion").val("");
                                $(".sltAccionEdit").val("");
                                $(".txtaDescEdit").val("");
                            }
                        }
                    });
                }
            });
        }
    });
});

function peticion(url, parametros, type, dataType, callback) {
    $.ajax({
        url: url,
        async: false,
        data: parametros,
        beforeSend: function(objeto) {
            dialogLoading('show');
        },
        complete: function(objeto, exito) {
            dialogLoading('close');
        },
        contentType: "application/x-www-form-urlencoded",
        dataType: dataType,
        error: function(objeto, quepaso, otroobj) {
            alert("En Contacto hay un error: " + otroobj);
            var datos = {
                "error": otroobj,
                "result": []
            };
            callback(datos);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function(datos) {
            callback(datos);
            //            alert(datos);
        },
        timeout: 3000,
        type: type
    });
}

function traerMensajes(textoBuscar, estado, inicio) {
    var parametros = {
        tarea: "buscador",
        estado: estado,
        textoBuscar: textoBuscar
    };
    peticion("respuestaContacto.php?_=" + new Date().getTime(), parametros, "GET", "JSON", function(datos) {
        if (datos.error.length <= 0) {
            var trHead = "";
            trHead = "<tr>";
            trHead += "   <th>Estado</th>";
            trHead += "   <th>Email</th>";
            trHead += "   <th>Mensaje</th>";
            trHead += "   <th>Fecha</th>";
            trHead += "   <td></td>";
            trHead += "</tr>";
            var trBody = "";
            if (datos.result.length > 0) {
                $.each(datos.result, function(i) {
                    trBody += "<tr style='height:33px;' class=' " + ((datos.result[i].estado == "C") ? "active" : "") + "' " + "        data-id='" + datos.result[i].id_contacto + "'          data-empresa='" + datos.result[i].empresa + "'       data-nombre='" + datos.result[i].nombre_apellido + "'  data-cargo='" + datos.result[i].cargo + "' " + "        data-email='" + datos.result[i].email + "'             data-telefono='" + datos.result[i].telefono + "'       data-ciudad='" + datos.result[i].ciudad + "'           data-estado='" + datos.result[i].estado + "'       data-mensaje='" + datos.result[i].mensaje + "'         data-idMensaje='" + datos.result[i].id_mensaje_contacto + "'       data-fecha='" + datos.result[i].fecha_sistema + "'>";
                    trBody += " <td style='width: 5%;'><label>" + datos.result[i].estado + "</label></td>";
                    trBody += " <td style='width: 20%;'><label>" + datos.result[i].email + "</label></td>";
                    trBody += " <td style='width: 60%; overflow: hidden; max-width:180px;  max-height:33px; white-space: nowrap;'><label>" + datos.result[i].mensaje + "</label></td>";
                    trBody += " <td style='width: 15%;'>" + datos.result[i].fecha_sistema + "</td>";
                    trBody += "<td>" + "       <span class='btn btn-primary btn-xs btnResponder'" + "        data-id='" + datos.result[i].id_mensaje_contacto + "'          data-empresa='" + datos.result[i].empresa + "'       data-nombre='" + datos.result[i].nombre_apellido + "'  data-cargo='" + datos.result[i].cargo + "' " + "        data-email='" + datos.result[i].email + "'             data-telefono='" + datos.result[i].telefono + "'       data-ciudad='" + datos.result[i].ciudad + "'           data-estado='" + datos.result[i].estado + "'       data-mensaje='" + datos.result[i].mensaje + "'         data-idMensaje='" + datos.result[i].id_mensaje_contacto + "'       data-fecha='" + datos.result[i].fecha_sistema + "'>Ver</span></td><td>" + "       <span class='btn btn-success btn-xs btnResponder'" + "        data-id='" + datos.result[i].id_mensaje_contacto + "'          data-empresa='" + datos.result[i].empresa + "'       data-nombre='" + datos.result[i].nombre_apellido + "'  data-cargo='" + datos.result[i].cargo + "' " + "        data-email='" + datos.result[i].email + "'             data-telefono='" + datos.result[i].telefono + "'       data-ciudad='" + datos.result[i].ciudad + "'           data-estado='" + datos.result[i].estado + "'       data-mensaje='" + datos.result[i].mensaje + "'         data-idMensaje='" + datos.result[i].id_mensaje_contacto + "'       data-fecha='" + datos.result[i].fecha_sistema + "'>Acciones</span></td></tr>";
                });
                if (datos.result.length > 3 && estado == 'R' && inicio) {
                    enviarCorreo("gerencia@nuevastic.com", "Adminstrador", "Responder contactos", "Responder contactos")
                }
            }
            $("#trHead").html(trHead);
            $("#trBody").html(trBody);
            // $("#tabla").dataTable();
        }
    });
}
//function enviarCorreo(correo, nombre, mensaje, asunto) {
//    var parametros = {
//        email: correo,
//        nombre: nombre,
//        mensaje: mensaje,
//        fileName: fileName,
//        fileBase64: fileBase64,
//        asunto: asunto,
//        tarea: 'enviar_email'
//    };
//    $.ajax({
//        url: "respuestaContacto.php",
//        async: true,
//        data: parametros,
//        beforeSend: function (objeto) {
////                dialogLoading('show');
//        },
//        complete: function (objeto, exito) {
////                dialogLoading('close');
//            if (exito == "success") {
//
//            }
//        },
//        contentType: "application/x-www-form-urlencoded",
//        dataType: "text",
//        error: function (objeto, quepaso, otroobj) {
//            alert("En Contacto hay un error: " + otroobj);
//        },
//        global: true,
//        ifModified: false,
//        processData: true,
//        success: function (datos) {
//            alert(datos)
////            if (datos == "El mensaje ha sido enviado") {
////                alert("El mensaje a sido contestado satisfactoriamente");
////            }
////            alert(datos);
//        },
//        timeout: 10000,
//        type: "POST"
//    });
//}
function ListarAccione(datos) {
    acciones = "";
    $.each(datos, function(i) {
        acciones += '<spant class="list-group-item" data-toggle="collapse" data-parent="#accordion" aria-expanded="false">' + '       <table style="width: 100%;">' + '           <tr>' + '               <td  style="width: 24%;">'
        if (datos[i].accion == 'llamada') {
            acciones += '<a href="#" class="editAccion" ' + '                   data-id="' + datos[i].id_accion_mensaje_contacto + '" data-accion="' + datos[i].accion + '"' + '                   data-descripcion="' + datos[i].descripcion + '">' + datos[i].accion + '</a></td>'
        } else {
            acciones += datos[i].accion + '</td>'
        }
        acciones += '               <td style="width: 50%;">' + datos[i].descripcion + '</td>' + '               <td style="width: 26%;">' + datos[i].fecha_sistema + '</td>' + '           </tr>' + '       </table>' + '   </spant>';
    });
    return acciones;
}
$(document).on('change', '#file', function() {
    fileName = this.files[0].name;
    var urlArc = $(this).val();
    // VERIFICAR QUE HAYA ARCHIVO
    if (this.files && this.files[0]) {
        datosFile = this.files[0];
        // LEER FICHERO QUE ESTÁ EN MEMORIA
        var fileReader = new FileReader();
        // CODIFICAR
        fileReader.readAsDataURL(this.files[0]);
        fileReader.onloadstart = function(e) {
            //            myApp.showPreloader('cargando');
        };
        fileReader.onerror = function(e) {
            //            myApp.hidePreloader();
            alert('Error al cargar el archivo ');
        };
        fileReader.updateProgress = function(e) {
            if (e.loaded >= e.total) {
                //                myApp.hidePreloader();
            }
        };
        // ESPERAR A QUE ESTÉ LISTO
        fileReader.onload = function(e) {
            //            myApp.hidePreloader();
            fileBase64 = fileReader.result;
            try {
                var tm = fileBase64.split('base64,');
                fileBase64 = tm[1];
                console.log(fileBase64);
            } catch (ex) {
                alert('Error try al cargar el archivo:' + ex);
            }
        };
    }
});