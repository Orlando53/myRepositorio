<?php

/*
 * @autor:         Juan Diego Ninco
 * @fecha:         24-07-2017
 * @objetivo:      inicio de sesión
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../rsc/session.php';
if (session::existsAttribute("LOGEADO") == true) {
    header("location:../index.php");
}
?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
            <title>
                Inicio de Sesión
            </title>
            <script>
                var url = "http://" + location.hostname + "/sstplus/sstplus/";
            </script>
            <link href="../css/bootstrap.min.css" rel="stylesheet">
                <link href="../css/nvst.css" rel="stylesheet">
                    <link href="../css/style.css" rel="stylesheet">
                    <link rel="icon" type="image/png" sizes="32x32" href="../../images/favicon-32x32.png">
                        <meta content="minimum-scale=0.75, maximum-scale=1.0" name="viewport">
                            <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
                                <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
                                </link>
                            </link>
                        </meta>
                    </link>
                </link>
            </link>
        <link rel="stylesheet" type="text/css" href="../css/alertify.core.css">
        <link rel="stylesheet" type="text/css" href="../css/alertify.default.css">
        </meta>
    </head>
    <body>
        <div class="container">
            <!-- Inicio del Contenedor Principal-->
            <div class="well col-md-6 col-md-offset-3 login-form">
                <img class="img-responsive center-block" src="../media/image/logo.png">
                    <form method="get">
                        <div class="form-group">
                            <label for="user">
                                Usuario
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-user">
                                    </span>
                                </div>
                                <input class="form-control" id="user" required="" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">
                                contraseña
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-asterisk">
                                    </span>
                                </div>
                                <input class="form-control" id="contrasena" pattern=".{6,}" required="" title="más de 6 caracteres" type="password"/>
                            </div>
                        </div>
                        <input class="btn btn-default" id="btnRegistrar" type="button" value="Registrar">
                            <a class="pull-right" data-target="#olvidoContrasena" data-toggle="modal" href="#">
                                Olvidé mi Contraseña
                            </a>
                        </input>
                    </form>
                </img>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="olvidoContrasena" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form action="validaremail.php" id="frmRestablecer" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    ×
                                </button>
                                <h4 class="modal-title">
                                    Restaurar Contraseña
                                </h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Escriba la dirección de Correo electrónico asociada a su cuenta
                                </p>
                                <br>
                                    <div class="form-group inline">
                                        <label for="email">
                                            E-mail:
                                        </label>
                                        <input class="form-control" id="email" name="email" type="email">
                                        </input>
                                    </div>
                                    <div align="center" id="respuesta">
                                    </div>
                                </br>
                            </div>
                            <div class="modal-footer">
                                <input class="btn btn-success" id="btn-restaurar" type="button" value="Restaurar">
                                </input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Fin del Contenedor Principal-->
        <script src="../js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="../js/jquery-ui.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/jquery.blockUI.js" type="text/javascript"></script>
        <!--<script type = "text/javascript" src= "../js/nvt.js"></script>-->
        <script src = "../js/alertify.js"></script>
        <script src="../js/jquery.funciones.js" type="text/javascript"></script>
        <script src="js/restaurarContrasena.js" type="text/javascript"></script>
        <script src="js/login.js" type="text/javascript">
        </script>
    </body>
</html>
