<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


        <style>
            #container {
                min-width: 310px;
                max-width: 800px;
                height: 400px;
                margin: 0 auto
            }
        </style>

    </head>
    <body>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="list-preguntas list-group">
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="radio">
                    <label>
                        <input type="radio" name="opciones" id="opciones_1" value="Columnas" checked>
                        Grafico en Columnas
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="opciones" id="opciones_2" value="Torta">
                        Grafico en Torta
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="opciones" id="opciones_3" value="Lineas">
                        Grafico en Lines
                    </label>
                </div>
                <div id="container"></div>
            </div>
        </div>

        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <!--<script src="../../js/bootstrap.min.js" type="text/javascript"></script>-->
        <!-- Versión compilada y comprimida del JavaScript de Bootstrap -->
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="js/graficos.js"></script>
    </body>
</html>
