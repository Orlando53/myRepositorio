$(document).ready(function() {
    var titulo;
    var data = [];
    var categorias = [];
    Listar()
    $('input:radio[name=opciones]').change(function() {
        if ($(this).val() == 'Columnas') {
            grafico_columnas(titulo, data, categorias)
        } else if ($(this).val() == 'Torta') {
            grafico_torta(titulo, data)
        } else {
            grafico_lineas(titulo, data, categorias)
        }
    })
    $('.list-preguntas').on('click', '.list-group-item', function() {
        titulo = $(this).text()
        data = [];
        categorias = [];
        var parametros = {
            accion: "listar_respuestas",
            v1: $(this).data('definicion')
        };
        $.ajax({
            url: "datosEncuesta.php",
            async: false,
            beforeSend: function(objeto) {
                //               dialogLoading('show');
            },
            complete: function(objeto, exito) {
                //                dialogLoading('close');
                if (exito == "success") {}
            },
            contentType: "application/json",
            dataType: "json",
            error: function(objeto, quepaso, otroobj) {
                alert("Hay un error: " + otroobj);
            },
            global: true,
            ifModified: false,
            processData: true,
            data: parametros,
            success: function(datos) {
                var preguntas = datos;
                //                alert(JSON.stringify(preguntas))
                categorias = [];
                $.each(preguntas, function(i) {
                    data.push([preguntas[i].detalle_definicion, Math.round(Math.random() * 10)]);
                    categorias.push(preguntas[i].detalle_definicion)
                });
                if ($('input:radio[name=opciones]:checked').val() == 'Columnas') {
                    grafico_columnas(titulo, data, categorias)
                } else if ($('input:radio[name=opciones]:checked').val() == 'Torta') {
                    grafico_torta(titulo, data)
                } else {
                    grafico_lineas(titulo, data, categorias)
                }
            },
            timeout: 3000,
            type: "GET"
        });
    })
})

function Listar() {
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
            var preguntas = datos;
            //alert(JSON.stringify(preguntas[contador]))
            contador = 1;
            $('.list-preguntas').empty();
            var lista = ''
            $.each(preguntas, function(i) {
                lista += '<button type="button" class="list-group-item" data-tipo="' + preguntas[i].id_tipo + '" data-id_pregunta="' + preguntas[i].id_pregunta + '" data-definicion="' + preguntas[i].detalle_def + '">' + preguntas[i].pregunta + '</button>'
            });
            $('.list-preguntas').html(lista)
        },
        timeout: 3000,
        type: "GET"
    });
}

function grafico_columnas(titulo, data, categorias) {
    Highcharts.chart('container', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Encuesta Sociodemográfica'
        },
        subtitle: {
            text: null
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: categorias
            //categories: Highcharts.getOptions().lang.shortMonths
        },
        //        yAxis: {
        //            title: {
        //                text: null
        //            }
        //        },
        series: [{
            type: 'column',
            name: titulo,
            data: data
            //                        [
            //                    //['> de 18 años', 45.0],
            //                    {
            //                        name: '> de 18 años',
            //                        y: 45,
            //                        sliced: true,
            //                        selected: true
            //                    },
            //                    ['18 - 27 Años', 26.8],
            //                    {
            //                        name: '28 - 37 Años',
            //                        y: 12.8,
            //                        sliced: true,
            //                        selected: true
            //                    },
            //                    ['38 - 47 Años', 8.5],
            //                    ['< 48 Años', 6.2]
            //                ]
        }]
        //        series: [{
        //                name: '> de 18 años',
        //                data: [49]
        //
        //            }, {
        //                name: '18 - 27 Años',
        //                data: [83]
        //
        //            }, {
        //                name: '28 - 37 Años',
        //                data: [48]
        //
        //            }, {
        //                name: '38 - 47 Años',
        //                data: [42]
        //
        //            }, {
        //                name: '< 48 Años',
        //                data: [42]
        //
        //            }]
    });
}

function grafico_torta(titulo, data) {
    Highcharts.chart('container', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Encuesta Sociodemográfica'
        },
        tooltip: {
            //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: titulo,
            data: data
            //                        [
            //                    //['> de 18 años', 45.0],
            //                    {
            //                        name: '> de 18 años',
            //                        y: 45,
            //                        sliced: true,
            //                        selected: true
            //                    },
            //                    ['18 - 27 Años', 26.8],
            //                    {
            //                        name: '28 - 37 Años',
            //                        y: 12.8,
            //                        sliced: true,
            //                        selected: true
            //                    },
            //                    ['38 - 47 Años', 8.5],
            //                    ['< 48 Años', 6.2]
            //                ]
        }]
    });
}

function grafico_lineas(titulo, data, categorias) {
    Highcharts.chart('container', {
        title: {
            text: 'Encuesta Sociodemográfica'
        },
        subtitle: {
            text: 'null'
        },
        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        //    plotOptions: {
        //        series: {
        //            pointStart: 2010
        //        }
        //    },
        xAxis: {
            categories: categorias
            //categories: Highcharts.getOptions().lang.shortMonths
        },
        series: [{
            name: titulo,
            data: data
        }]
    });
}