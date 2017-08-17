<?php

/*
 * @autor:         Jose Erick
 * @fecha:         24-07-2017
 * @objetivo:      acciones para cargos
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
    <meta charset="utf-8">
    <title>Cargos Empresa</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">
    <link href="../../css/bootstrap-select.css" rel="stylesheet">
    <link href="../../css/nvst.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../css/validationEngine.jquery.css" rel="stylesheet">
    <link href="../../../images/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">

    <meta content="minimum-scale=0.75, maximum-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="col-md-1 goback">
            <div class="col-md-1 col-md-offset-1 goback"><a href="../index.php"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
        </div>
        <form id="frmOperaciones" method="post">
        <div class="col-md-10 floater">
            <h2>
                Cargos de la Empresa
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
                <input class="nvt-btn nvt-btn-primary" data-target="#insertarModal" data-toggle="modal" type="button" value="Nuevo">
                    <input class="nvt-btn nvt-btn-primary" type="button" value="Eliminar" id="btnEliminar" onclick = "this.form.action = 'eliminarCargos.php'">
                        <input class="nvt-btn nvt-btn-primary" type="button" value="Modificar" id="btnModificar" onclick = "this.form.action = 'actualizarCargos.php'">
                            <!-- <input class="nvt-btn nvt-btn-primary" type="button" value="Exportar"> -->
                            <a href="#"><img src="../../media/icon/check.png" class="form-check" id="imgCheck"></a>
            </div>
            <table id="tabla" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <div class="checkbox-input"> <input type="checkbox"  name="" id="" value="" onclick="marcar(this);">#</div>
                                </th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Jefe Inmediato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'listarCargos.php';?>
                        </tbody>
                    </table>

        </div>
        </form>
        <div class="col-md-1">
            <a data-target="#ayudaModal" data-toggle="modal" href="#ayuda">
                <img data-placement="bottom" data-toggle="tooltip" src="../../media/icon/help.png" title="Ayuda"/>
            </a>
        </div>
    <!-- Modal Insertar -->
    <div aria-labelledby="myModalLabel" class="modal fade" id="insertarModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
        <form id="frmCargos"  method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="actualizar();">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Registrar Nuevo Cargo
                    </h4>
                </div>
                <div class="modal-body">
                    <!--Modal Body-->

                        <div class="nvt-input-group two-third">
                            <input id="txtNombre" name="nombre" type="text" class="validate[required]">
                                <span class="bar">
                                </span>
                                <label for="txtNombre">
                                    Nombre del cargo
                                </label>
                            </input>
                        </div>
                        <div class="nvt-input-group third">
                            <select name = "selJefe[]" id="selJefe" class="selectpicker validate[required]" title="Seleccione" data-live-search="true">
                             <option value="0">Ninguno</option>
                            </select>
                            <label for="selJefe">
                                Jefe Inmediato
                            </label>
                        </div>
                        <div class="nvt-input-group full">
                            <textarea name ="descripcion" id="txtDescripcion" class="validate[required]"></textarea>
                            <label for="txtDescripcion">
                                Descripción del cargo
                            </label>
                            <p class="charcount">
                            </p>
                        </div>

                </div>
                <div class="modal-footer">
                    <button class="nvt-btn nvt-btn-default" data-dismiss="modal" type="button" onclick="actualizar();">
                        Cerrar
                    </button>
                     <button type="button" class="nvt-btn nvt-btn-primary" id="btn-guardarCargos">Guardar Datos</button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- Modal Actualizar -->
    <div aria-labelledby="myModalLabel" class="modal fade" id="actualizarModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
        <form id="frmActualizarCargo"  method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="actualizar();">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Actualizar Cargo
                    </h4>
                </div>
                <div class="modal-body">
                    <!--Modal Body-->
                <div class="nvt-input-group two-third">
                    <input id="txtNombreAct" name="nombreAct" type="text" value="">
                    <input type="hidden" name="id_cargo" id="id_cargo" value="">
                    <span class="bar"></span>
                    <label for="txtNombre">Nombre del cargo</label>
                    </input>
                </div>
                <div class="nvt-input-group third">
                    <select name = "selJefeAct[]" id="selJefeAct" class="selectpicker validate[required]" title="Seleccione" data-live-search="true"></select>
                    <label for="selJefe">Jefe Inmediato</label>
                </div>
                <div class="nvt-input-group full">
                    <textarea name ="descripcionAct" id="txtDescripcionAct"></textarea>
                    <label for="txtDescripcion">Descripción del cargo</label>
                    <p class="charcount"></p>
               </div>
                </div>
                <div class="modal-footer">
                    <button class="nvt-btn nvt-btn-default" data-dismiss="modal" type="button" onclick="actualizar();">
                        Cerrar
                    </button>
                     <button type="button" class="nvt-btn nvt-btn-primary" id="btn-actualizarCargos" onclick = "this.form.action = 'confirmarActualizacionCargos.php'">Actualizar</button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- Modal Eliminar -->
        <div class="modal fade" id="cargandoElimina" align="center" role="dialog"></div>
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
                    <video autoplay controls>
                        <source src="../../gen/paso3.mp4" type="video/mp4"/>
                    </video>
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
<script src = "../../js/jquery-ui.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src = "../../js/alertify.js"></script>
<script src="../../js/bootstrap-select.js"></script>
<script src="../../js/nvt.js"></script>
<script src="../../js/jquery.jCombo.js"></script>
<script src="../../js/jquery.dataTables.js"></script>
<script src="../../js/tables.js"></script>
<script src="../../js/jquery.validationEngine.js"></script>
<script src="../../js/languages/jquery.validationEngine-es.js"></script>
<script src = "../../js/jquery.funciones.js"></script>
<script src="js/Cargos.js"></script>
</body>