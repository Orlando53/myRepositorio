
<?php

/*
 * @autor:         Juan Diego Ninco Collazos
 * @fecha:         25-07-2017
 * @objetivo:      acciones para usuarios
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
    <title>Usuarios</title>
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
    <link rel="stylesheet" href="../../css/validationEngine.jquery.css">
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-select.js"></script>
    <script src="../../js/nvt.js"></script>
    <script src="../../js/jquery.dataTables.js"></script>
    <script src="../../js/tables.js"></script>
    <script type="text/javascript" src="../../js/jquery.jCombo.js"></script>
    <script type="text/javascript" src="../../js/jquery.funciones.js"></script>
    <script src="../../js/languages/jquery.validationEngine-es.js" type="text/javascript"></script>
    <script src="../../js/jquery.validationEngine.js" type="text/javascript"></script>
    <!-- <script type="text/javascript">accion_usuario=''; </script> -->
    <script src = "../../js/alertify.js"></script>
</head>
<body>
            <div class="row">
            <div class="col-md-1 goback"><a href="../index.php"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
            <div class="col-md-10 floater">
                                        <h2>
                                            Usuarios
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
                                                <input type="button" class="nvt-btn nvt-btn-primary" id="btn_insertar" value="Nuevo">
                                                    <input class="nvt-btn nvt-btn-primary" type="button" id="btn_eliminar" value="Eliminar">
                                                        <input class="nvt-btn nvt-btn-primary" id="btn_modificar" type="button" value="Modificar">
                                                                <a id="btn_terminar" href="#"><img src="../../media/icon/check.png" class="form-check" id="imgCheck"></a>

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
                                                    Fecha de Registro
                                                </th>
                                                <th>
                                                    Cargo
                                                </th>
                                                <th>
                                                    Area
                                                </th>
                                                <th>
                                                    Estado
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php include 'listaUsuarios.php';?>
                                            </tbody>
                                        </table>

        </div>
            <div class="col-md-1"><a href="#ayuda" data-toggle="modal" data-target="#ayudaModal"><img src="../../media/icon/help.png"  data-toggle="tooltip" data-placement="bottom" title="Ayuda"></a></div>
        </div>




        <!-- Modal Insertar -->
        <div class="modal fade" id="insertarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content" id="contenedor">
            </div>
          </div>
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
                                                <video controls>
                                                    <source src="../../gen/paso5.mp4" type="video/mp4"/>
                                                </video>
                                            </div>
                             <!--                <div class="modal-footer">
                                                <button class="nvt-btn nvt-btn-default" data-dismiss="modal" type="button">
                                                    Cerrar
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

    <script src="./js/listaUsuarios.js"></script>
</body>
