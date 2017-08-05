<?php
/*
 * @autor:
 * @fecha:
 * @objetivo:
 * @Modifico:       Orlando Puentes
 * @Fecha:          julio 28 de 2018
 * @Modificacion:   cambio de extensi�n, impresi�n de usuario y razon social
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once 'rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
require_once 'rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: login/index.php");
}
$id_empresa  = session::getAttribute("IDEMPRESA");
$nom_usuario = session::getAttribute('NOMBRE');
$columnas    = "razon_social";
$tabla       = "gen_empresas";
$condicion   = "id_empresa = :v1";
$valores     = array(":v1" => $id_empresa);
$rs          = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
$rz          = $rs[0]['razon_social'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido a SSTPlus</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <link rel="stylesheet" href="css/nvst.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="media/image/favicon-32x32.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/validationEngine.jquery.css">

</head>
<body>
  <header id="header" class="fixed">
    <div class="menu-container">
      <div class="row head">

        <div class="col-xs-8 col-sm-2 col-md-2 logo"><a href="#home"><img src="media/image/logo.png" class="img-responsive center-block"></a></div>

        <div class="col-md-7 menu-holder">
          <ul class="main-menu">
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Inicio"><img src="media/icon/home.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="A Rapido"><img src="media/icon/a-rapido.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Actas"><img src="media/icon/actas.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Procesos"><img src="media/icon/proc.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Tareas"><img src="media/icon/tareas.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Configuración"><img src="media/icon/config.png"></a></li>
            <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Notificaciones"><img src="media/icon/notif.png"></a></li>
          </ul>
        </div>
        <div class="col-md-3 userholder">
          <i class="fa fa-user-circle-o"></i>
          <div class="userinfo">
            <h5><?php echo $nom_usuario; ?></h5>
            <h5><?php echo $rz; ?></h5>
          </div>
          <div class="usercontent hidden">
            <h4>Menú de Usuario</h4>
            <ul>
              <li><a data-target="#modal_menu" data-toggle="modal" href="#" onclick="contenido_modal('Perfil Usuario','main/subMenu/perfil.php')">Perfil</a></li>
              <li><a data-target="#modal_menu" data-toggle="modal" href="#" onclick="contenido_modal('Cambiar Contraseña','main/subMenu/formularioContrasena.php')">Cambiar Contraseña</a></li>
              <li><a href="main/subMenu/cerrarSession.php">Cerrar Sesión</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="container-fluid fixed-top"><!-- Inicio del Contenedor Principal-->
    <iframe src="<?php echo $_REQUEST['ruta']; ?>" height="599px;" width="100%" style="border:none;min-height:585px;" name="iframe_a" scrolling="no" id="iframe_a" onload="resizeIframe(this);" allowfullscreen ></iframe>
  </div><!-- Fin del Contenedor Principal-->
  <!-- Modal con las opciones del usuario desde una vez logueado-->
        <div class="modal fade" id="modal_menu" role="dialog">
            <div class="modal-dialog">
                <!-- Contenido-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">
                            ×
                        </button>
                        <h4 class="modal-title">
                            <p id="titulo_modal_menu">
                            </p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="alerta_modal">
                        </div>
                        <div id="contenido_modal_menu">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-select.js"></script>
  <script src="js/nvt.js"></script>
  <script src="js/this_view.js"></script>
  <script src="main/subMenu/js/modal_menu.js"></script>
  <script src = "js/jquery.blockUI.js"></script>
  <script src="js/languages/jquery.validationEngine-es.js" type="text/javascript"></script>
  <script src="js/jquery.validationEngine.js" type="text/javascript"></script>
  <script>
  function resizeIframe(obj) {
    //obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    var iFrameID = document.getElementById('iframe_a');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }
  }
  </script>
</body>
</html>
