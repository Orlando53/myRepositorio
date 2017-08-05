/*!
 * @autor:      Walther Rojas 
 * @fecha:      julio 25 de 2017
 * @objetivo: Gestionar Encuesta Sociodemográfica
 */
var ruta = "";
ruta = URLactual();
var preguntas;
var contador = 0;
var respuestas = {};
$(document).ready(function() {
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    $(".step-form").on('click', '.next', function() {
        var _id = $(this).data('respuesta')
        if ($('#' + _id).validationEngine('validate')) {
            return false
        }
        respuestas['pregunta' + $(this).data('id_pregunta')] = {
            id_pregunta: $(this).data('id_pregunta'),
            id_tipo: $(this).data('tipo'),
            id_detalle_def: $('#' + _id).val()
        };
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 0,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });
    $(".step-form").on('click', '.previous', function() {
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 0,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });
    $('#myModal').modal('show');
    $('#myModal').on('hide.bs.modal', function() {
        $('.selectpicker').selectpicker('refresh');
    });
    var parametros = {
        accion: "listar"
    };
    $.ajax({
        url: "datosEncuesta.php",
        async: false,
        beforeSend: function(objeto) {
            //                dialogLoading('show');
        },
        complete: function(objeto, exito) {
            //                dialogLoading('close');
            if (exito == "success") {}
        },
        contentType: "application/json",
        dataType: "json",
        error: function(objeto, quepaso, otroobj) {
            alert("En Contacto hay un error: " + otroobj);
        },
        global: true,
        ifModified: false,
        processData: true,
        data: parametros,
        success: function(datos) {
            preguntas = datos;
            //alert(JSON.stringify(preguntas[contador]))
            contador = 1;
            $.each(preguntas, function(i) {
                var pre = ""
                if (preguntas[i].id_tipo == 2) {
                    pre = '<fieldset>' + '<h2>Pregunta ' + contador + '</h2>' + '<h3>' + preguntas[i].pregunta + '</h3>' + '<div class="nvt-input-group full">' + '   <select class="selectpicker validate[required]" id="sltPreg' + contador + '">' + '      <option value="">Seleccione</option>' + '      <option value="1">Si</option>' + '       <option value="0">No</option>' + '   </select>' + '   <span class="bar"></span>' + '   <label for="txtPreg' + contador + '">Respuesta</label>'
                    if (contador == preguntas.length) {
                        pre += '<p>Ley 1581 de 2012: de protección de datos personales,  es una ley que complementa la regulación vigente para la protección del derecho fundamental que tienen todas las personas naturales a autorizar la información personal que es almacenada en bases de datos o archivos, así como su posterior actualización y rectificación.</p>'
                    }
                    pre += '</div>'
                    if (contador > 1) {
                        pre += '<input type="button" class="previous nvt-btn nvt-btn-primary" value="Anterior" />'
                        if (contador == preguntas.length) {
                            pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="btn-enviar nvt-btn nvt-btn-primary" value="Enviar" />'
                        } else {
                            pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="next nvt-btn nvt-btn-primary" value="Siguiente" />'
                        }
                    } else {
                        pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="next nvt-btn nvt-btn-primary" value="Siguiente" />'
                    }
                    pre += '</fieldset>'
                    $('form').append(pre)
                } else if (preguntas[i].id_tipo == 1) {
                    pre = '<fieldset>' + '<h2>Pregunta ' + contador + '</h2>' + '<h3>' + preguntas[i].pregunta + '</h3>' + '<div class="nvt-input-group full">' + '        <select class="selectpicker validate[required]" id="sltPreg' + contador + '">' + '        </select>' + '        <span class="bar"></span>' + '        <label for="txtPreg2">Respuesta</label>'
                    if (contador == preguntas.length) {
                        pre += '<p>Ley 1581 de 2012: de protección de datos personales,  es una ley que complementa la regulación vigente para la protección del derecho fundamental que tienen todas las personas naturales a autorizar la información personal que es almacenada en bases de datos o archivos, así como su posterior actualización y rectificación.</p>'
                    }
                    pre += '</div>'
                    if (contador > 1) {
                        pre += '<input type="button" class="previous nvt-btn nvt-btn-primary" value="Anterior" />'
                        if (contador == preguntas.length) {
                            pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="btn-enviar nvt-btn nvt-btn-primary" value="Enviar" />'
                        } else {
                            pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="next nvt-btn nvt-btn-primary" value="Siguiente" />'
                        }
                    } else {
                        pre += '<input type="button" data-respuesta="sltPreg' + contador + '" ' + 'data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" ' + 'class="next nvt-btn nvt-btn-primary" value="Siguiente" />'
                    }
                    pre += '</fieldset>'
                    $('form').append(pre)
                    $("#sltPreg" + contador).jCombo("../../util/definiciones.php?id=" + preguntas[i].detalle_def, {
                        initial_text: "Seleccione Respuesta"
                    });
                }
                contador += 1;
            });
        },
        timeout: 3000,
        type: "GET"
    });
    $(".step-form").on('click', '.btn-enviar', function() {
        var _id = $(this).data('respuesta')
        if (!$('#' + _id).validationEngine('validate')) {
            respuestas['pregunta' + $(this).data('id_pregunta')] = {
                id_pregunta: $(this).data('id_pregunta'),
                id_tipo: $(this).data('tipo'),
                id_detalle_def: $('#' + _id).val()
            };
            Guardar();
        }
    })

    function Guardar() {
        var parametros = {
            respuestas: respuestas,
            accion: 'guardar'
        };
        $.ajax({
            url: "datosEncuesta.php",
            async: false,
            beforeSend: function() {
                dialogLoading('show');
            },
            complete: function() {
                dialogLoading('close');
            },
            contentType: "application/json",
            dataType: "text",
            error: function(objeto, quepaso, otroobj) {
                alert("En Contacto hay un error: " + otroobj);
            },
            global: true,
            ifModified: false,
            processData: true,
            data: parametros,
            success: function(datos) {
                if (datos == 1) {
                    alert('Se guardado correctamente');
                    window.location = '../../index.php?ruta=main/menuPrincipal.php';
                } else {
                    alert('No se pudo guardar');
                }
            },
            timeout: 3000,
            type: "GET"
        });
    }
})