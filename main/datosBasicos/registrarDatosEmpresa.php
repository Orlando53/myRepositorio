<?php

/*
 * @autor:         Walther
 * @fecha:         24-07-2017
 * @objetivo:      registrar empresas
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Datos empresa</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-select.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/nvst.css">
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/validationEngine.jquery.css">
        <link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
        <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">
        <link rel="icon" type="image/png" sizes="32x32" href="../../../images/favicon-32x32.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">

        <style>
            .novalido{color: red;padding-left: 45px}
        </style>
    </head>
    <body>
        <br />
        <form class="datosEmpresa">
            <div class="row">
                <div class="col-md-1 col-md-offset-1 goback"><a href="../index.php" class="goback"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
                <div class="col-md-8 floater">
                    <h2>Datos de la Empresa</h2>
                    <div class="nvt-input-group half">
                        <input type="text" name="Nombre" id="nombre" class="text-uppercase validate[required]">
                        <span class="bar"></span>
                        <label for="nombre">Nombre o Razón Social</label>
                    </div>
                    <div class="nvt-input-group half" style="text-align: center;">
                        <h5>Logo</h5>
                        <div class="file-input">
                            <img  id="logoImg" >
                            <label for="logo">cambiar</label>
                            <input type="file" name="" class="imgFile" id="logo" accept="image/jpg,image/png">
                        </div>
                        <input type="button" class="nvt-btn nvt-btn-danger logoClear" value="X">
                    </div>
                    <div class="nvt-input-group third">
                        <select name="tipoIdentificacion" id="tipoIdentificacion" class="selectpicker validate[required]">
                            <option >Selecciona Uno</option>
                            <option >Nit</option>
                        </select>
                        <label for="tipoIdentificacion">Tipo de Identificación</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="text" name="numeroIdentificacion" id="numeroIdentificacion" class="validate[required],custom[integer],min[0]">
                        <span class="bar"></span>
                        <label for="numeroIdentificacion">Numero de Identificación</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="text" name="txtDigito" id="txtDigito" class="validate[required],custom[integer],min[0],max[9]" readonly>
                        <span class="bar"></span>
                        <label for="txtDigito">Dígito de Verificación</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="text" name="txtRepresentante" id="txtRepresentante" class="text-uppercase validate[required]">
                        <span class="bar"></span>
                        <label for="txtRepresentante">Representante Legal</label>
                    </div>
                    <div class="nvt-input-group half">
                        <select name="actividadEconomica" id="actividadEconomica" class="selectpicker validate[required]" data-live-search="true">
                            <option>Seleccione Uno</option>
                            <option value="6201">6201 - Actividades de Desarrollo de Sistemas de Información</option>
                        </select>
                        <label for="actividadEconomica">Actividad Económica</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="text" name="direccion" id="direccion" readonly class="validate[required]"/>
                        <span class="bar"></span>
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="email" name="email" id="email" class="text-lowercase validate[required],custom[email]">
                        <span class="bar"></span>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <div class="nvt-input-group third">
                        <select name="dpto" id="dpto" class="selectpicker validate[required]" data-live-search="true">
                            <option >Selecciona Uno</option>
                            <option >Huila</option>
                        </select>
                        <label for="dpto">Departamento</label>
                    </div>
                    <div class="nvt-input-group third">
                        <select name="mpio" id="mpio" class="selectpicker validate[required]" data-live-search="true">
                            <option >Selecciona Uno</option>
                            <option >Neiva</option>
                        </select>
                        <label for="mpio">Municipio</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input name="txtTelefono" id="txtTelefono" class="validate[required],custom[phone]">
                        <span class="bar"></span>
                        <label for="txtTelefono">Teléfono</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input name="sucursales" id="sucursales" class="validate[required],min[0]">
                        <span class="bar"></span>
                        <label for="sucursales">Número Sucursales</label>
                    </div>
                    <br>
                    <button id="btnGuardar" class="nvt-btn nvt-btn-primary" >Guardar Datos</button>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Dirección</h4>
                    </div>
                    <div class="modal-body" id="div-direccion">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnAceptar-dir" type="button" class="nvt-btn nvt-btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery-ui.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/bootstrap-select.js"></script>
        <script src="../../js/jquery.funciones.js"></script>
        <script src = "../../js/jquery.jCombo.js"></script>
        <script src = "../../js/alertify.js"></script>
        <script src="../../js/languages/jquery.validationEngine-es.js" type="text/javascript"></script>
        <script src="../../js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="js/registrarDatosEmpresa.js"></script>
    </body>
</html>
