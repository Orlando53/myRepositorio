


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
            <title>
                Inicio de Sesión
            </title>
            <link href="../css/bootstrap.min.css" rel="stylesheet">
                <link href="../css/nvst.css" rel="stylesheet">
                    <link href="../css/style.css" rel="stylesheet">
                        <!-- <link rel="icon" type="image/png" sizes="32x32" href="../../images/favicon-32x32.png"> -->
                        <meta content="minimum-scale=0.75, maximum-scale=1.0" name="viewport">
                            <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
                                <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
                                </link>
                            </link>
                        </meta>
                    </link>
                </link>
            </link>
            <link rel="stylesheet" href="../css/validationEngine.jquery.css">
            <link rel="stylesheet" type="text/css" href="../css/alertify.core.css">
            <link rel="stylesheet" type="text/css" href="../css/alertify.default.css">
        </meta>
    </head>
    <body>
        <div class="container">
            <!-- Inicio del Contenedor Principal-->
            <div class="well col-md-6 col-md-offset-3 login-form">
                <img class="img-responsive center-block" src="../media/image/logo.png">
                    <br>
                    <form method="get" id="cambioContrasena">
                    <h2><p id="pFormularioUsuario">Cambie su contraseña</p></h2>
                    <br>
                    <div class="nvt-input-group full">
                            <input type="text" id="usuario" class="validate[required]">
                            <span class="bar"></span>
                            <label for="txtNombre1">Usuario</label>
                    </div>
                    <div class="nvt-input-group full">
                            <input type="password"  id="contrasenaActual" class="validate[required]">
                            <span class="bar"></span>
                            <label for="txtNombre1">Contraseña actual</label>
                    </div>
                     <div class="nvt-input-group full">
                            <input type="password"  id="contrasenaNueva" class="validate[required]">
                            <span class="bar"></span>
                            <label for="txtNombre1">Contraseña nueva</label>
                    </div>
                     <div class="nvt-input-group full">
                            <input type="password" id="contrasenaConfirmada" class="validate[required]">
                            <span class="bar"></span>
                            <label for="txtNombre1">Confirmar contraseña</label>
                    </div>
                    <br>
                    <br>
                    <input class="nvt-btn nvt-btn-primary" id="btnConfirmar" type="button" value="Confirmar"></input>
                    </form>
                </img>
            </div>
        </div>
        <!-- Fin del Contenedor Principal-->
        <script src="../js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/jquery.blockUI.js" type="text/javascript"></script>
        <script src="../js/languages/jquery.validationEngine-es.js" type="text/javascript"></script>
        <script src="../js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src = "../js/alertify.js"></script>
        <script type="text/javascript" src="../seguridad/js/cambiarContrasena.js"></script>
    </body>
</html>
