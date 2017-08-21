<?php
/*
 *
 *
 * @Modifica:    Juan Diego Ninco Collazos
 * @fecha:       Agosto 04 de 2017
 * @objetivo:    mostrar empleados que hn respondido la encuesta sociodemografica

 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}
?>


<head>
    <meta charset="UTF-8">
    <title>Envio correos</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap-select.css" type="text/css"/>
    <link rel="stylesheet" href="../../css/nvst.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../../../images/favicon-32x32.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
<div class="row">
<div class="col-md-1 goback"><a href="../index.php"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
<div class="col-md-10 floater">
<h2>
Envio de correo electrónico
</h2>
<div class="nvt-input-group third">
                                            <input id="search" name="Nombre" type="search">
                                                <span class="bar">
                                                </span>
                                                <label for="search">
                                                    Buscar
                                                </label>
                                            </input>
                                        </div>
                                        <div class="nvt-button-group two-third right-align">
                                                        <input class="nvt-btn nvt-btn-primary" id="btn_reenviar" type="button" value="Reenviar correo">
                                                                <a id="btn_terminar" href="#"><img src="../../media/icon/check.png" class="form-check" id="imgCheck"></a>
                                                            </input>
                                                        </input>
                                                    </input>
                                                </input>
                                            </input>
                                        </div>

                                        <table id="tabla" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Imagen
                                                </th>
                                                <th>
                                                    N° de Identificación
                                                </th>
                                                <th>
                                                    Nombres
                                                </th>
                                                <th>
                                                    Apellidos
                                                </th>
                                                <th>
                                                    Cargo
                                                </th>
                                                <th>
                                                    Correo electrónico
                                                </th>
                                                <th>
                                                    Encuesta
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php include 'listaRespuestas.php';?>
                                            </tbody>
                                        </table>

        </div>
            <div class="col-md-1"><a href="#ayuda" data-toggle="modal" data-target="#ayudaModal"><img src="../../media/icon/help.png"  data-toggle="tooltip" data-placement="bottom" title="Ayuda"></a></div>
        </div>

                                                        <!-- Modal Ayuda -->
                            <div aria-labelledby="myModalLabel" class="modal fade" id="ayudaModal" role="dialog" tabindex="-1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                    <span aria-hidden="true">
                                                        ×
                                                    </span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Ayuda
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <!--Modal Body-->
                                                Información de Ayuda Referente a Esta Vista.
                                            </div>
                                            <div class="modal-footer">
                                                <button class="nvt-btn nvt-btn-default" data-dismiss="modal" type="button">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-select.js"></script>
    <script src="../../js/nvt.js"></script>
    <script src="../../js/jquery.dataTables.js"></script>
    <script src="../../js/tables.js"></script>
    <script type="text/javascript" src="../../js/jquery.funciones.js"></script>
    <script src = "../../js/alertify.js"></script>
    <script src = "./js/reenviarCorreo.js"></script>

</body>
