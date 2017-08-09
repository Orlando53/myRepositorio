<?php
/*
 * @autor:         Jose Eric Castro Cuadrado
 * @fecha:         25-07-2017
 * @objetivo:      Registro datos básicos de empresa
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registrar Empresa</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-select.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/nvst.css">
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/validationEngine.jquery.css">
        <link rel="icon" type="image/png" sizes="32x32" href="../../images/favicon-32x32.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
        <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">

    </head>
    <body>
        <br />
        <form class="datosEmpresa" id="datosEmpresa">
            <div class="row">
                <div class="col-md-1 col-md-offset-1 goback"><a href="../index.php" class="goback"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
                <div class="col-md-8 floater">
                    <h2>Datos de la Empresa</h2>
                    <div class="nvt-input-group two-third">

                        <?php
/*$id_plan = 1;*/
$id_plan = $_GET['id'];
echo '<input type="hidden" name="id_plan" id="id_plan" value="' . $id_plan . '">';
?>
                        <input type="text" name="nombre" id="nombre" class="validate[required]">
                        <span class="bar"></span>
                        <label for="nombre">Nombre o Razón Social</label>
                    </div>
                    <br>
                    <div class="nvt-input-group half">
                        <select name="tipoIdentificacion" id="tipoIdentificacion" class="selectpicker validate[required]" data-live-search="true">
                            <option >Selecciona Uno</option>
                            <option >Nit</option>
                        </select>
                        <label for="tipoIdentificacion">Tipo de Identificación</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="text" name="numeroIdentificacion" id="numeroIdentificacion" class="validate[required,custom[integer],min[1]]">
                        <span class="bar"></span>
                        <label for="numeroIdentificacion">Número de Identificación</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="text" name="direccion" id="direccion" class="validate[required]" readonly>
                        <span class="bar"></span>
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="email" name="email" id="email" class="validate[required, custom[email]]">
                        <span class="bar"></span>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="number" name="txtTelefono" id="txtTelefono" class="validate[required,custom[phone]]">
                        <span class="bar"></span>
                        <label for="txtTelefono">Teléfono</label>
                    </div>
                    <div class="nvt-input-group half">
                        <input type="number" name="numEmpleados" id="numEmpleados" class="validate[required,custom[integer],min[1]]">
                        <span class="bar"></span>
                        <label for="numEmpleados">Número de Empleados</label>
                    </div>
                    <h4 style="margin-top: 20px;">Representante Legal</h4>
                    <div class="row">
                    <div class="nvt-input-group col-md-3">
                        <input type="text" name="txtNombre1" id="txtNombre1" class="validate[required]">
                        <span class="bar"></span>
                        <label for="txtNombre1">Primer Nombre</label>
                    </div>
                    <div class="nvt-input-group col-md-3">
                        <input type="text" name="txtNombre2" id="txtNombre2" class="">
                        <span class="bar"></span>
                        <label for="txtNombre2">Segundo Nombre</label>
                    </div>
                    <div class="nvt-input-group col-md-3">
                        <input type="text" name="txtApellido1" id="txtApellido1" class="validate[required]">
                        <span class="bar"></span>
                        <label for="txtApellido1">Primer Apellido</label>
                    </div>
                    <div class="nvt-input-group col-md-3">
                        <input type="text" name="txtApellido2" id="txtApellido2" class="">
                        <span class="bar"></span>
                        <label for="txtApellido2">Segundo Apellido</label>
                    </div>
                    </div>
                    <br>
                    <button id="btnEnviarDatosEmpresa" class="nvt-btn nvt-btn-primary" >Enviar Datos</button>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form id="frmDirecciones" name="frmDirecciones">
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
        </form>
        </div>
       <!-- Modal -->
            <div class="modal fade" id="cargando" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body">
                                    <div align="center" id="cargando1">
                                    </div>
                                </br>
                            </div>
                            <div class="modal-footer" >
                                <button type="button" class="nvt-btn nvt-btn-primary" id="btnAceptar">Aceptar</button>
                            </div>
                        </div>
                </div>
            </div>


        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery-ui.js"></script>
        <script src="../../js/bootstrap.min.js"></script>  <!-- adm estilos -->
        <script src = "../../js/alertify.js"></script>
        <script src="../../js/bootstrap-select.js"></script>
        <script src="../../js/nvt.js"></script>

        <script src="../../js/languages/jquery.validationEngine-es.js" type="text/javascript"></script>
        <script src="../../js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="../../js/jquery.funciones.js"></script>
        <script type="text/javascript" src="../../js/jquery.jCombo.js"></script>
        <script src="js/registrarEmpresa.js"></script>

    </body>
</html>
