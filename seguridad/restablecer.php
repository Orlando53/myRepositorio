<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Restablecer Contraseña
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}

$token     = $_GET['token'];
$idusuario = $_GET['idusuario'];

$tabla     = "seg_restaurar_contrasena";
$columnas  = "*";
$condicion = "token = :v1";
$valores   = array(":v1" => $token);
$rs_res    = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if (count($rs_res) > 0) {

    if (sha1($rs_res[0]["id_usuario"]) == $idusuario) {
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restaurar Contraseña</title>
  <script>
  var url = "http://" + location.hostname + "/sstplus/";

  </script>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/nvst.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="../../images/favicon-32x32.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/alertify.core.css">
        <link rel="stylesheet" type="text/css" href="../css/alertify.default.css">
</head>
<body>
  <div class="container"><!-- Inicio del Contenedor Principal-->
    <div class="well col-md-6 col-md-offset-3 login-form">
    <img src="../media/image/logo.png" class="img-responsive center-block">
    <form action="cambiarpassword.php" method="post" id="frmCambiarPassword">
      <h3>Restaurar Contraseña</h3>
      <div class="form-group">
          <label for="nuevaContrasena">Nueva Contraseña</label>
          <input name="password1" pattern=".{6,}" required title="más de 6 caracteres" type="password" class="form-control" id="nuevaContrasena" required/>
      </div>
      <div class="form-group">
          <label for="confirmaContrasena">Confirmar Contraseña</label>
        <input name="password2" pattern=".{6,}" required title="más de 6 caracteres" type="password" class="form-control" id="confirmaContrasena" required/>
      </div>

          <!-- <div id="respuesta" align="center"></div> -->



      <input type="hidden" name="token" value="<?php echo $token ?>">
      <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
      <input id="btnRegistrar" type="button" class="btn btn-success pull-right" value="Restaurar Contraseña">
    </form>
    </div>
  </div><!-- Fin del Contenedor Principal-->
  <script type = "text/javascript" src= "../js/jquery-3.2.1.min.js"></script>
  <script src = "../js/jquery-ui.min.js"></script>
  <script type = "text/javascript" src= "../js/bootstrap.min.js"></script>
  <script type = "text/javascript" src= "../js/nvt.js"></script>
  <script src="../js/jquery.validationEngine.js"></script>
  <script src="../js/languages/jquery.validationEngine-es.js"></script>
  <script type = "text/javascript" src= "../js/jquery.funciones.js"></script>
  <script src = "../js/alertify.js"></script>
  <script type = "text/javascript" src= "js/restablecer.js"></script>



</body>
</html>

<?php
} else {
        header('Location:../../index.php');
    }
} else {
    header('Location:../../index.php');
}
?>