<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<script type = "text/javascript" src= "../js/jquery-3.2.1.min.js"></script>
<script type = "text/javascript" src= "../js/jquery-ui.js"></script>
<script type = "text/javascript" src= "../js/jquery.funciones.js"></script>

</head>
<body>
<div id="div-superior" title="Superior"></div>
<div id="div-iz_arriba" title="iz_arriba"></div>
<div id="div-de_arriba" title="de_arriba"></div>
<div id="div-de_abajo" title="de_abajo"></div>

<input type="hidden" id="txtRecurso" name="txtRecurso">


<?php
@session_start();
date_default_timezone_set('America/Bogota'); 
ini_set("display_errors",'1');
set_time_limit(0);

include_once '../rsc/DBManejador.php';
require_once '../rsc/session.php';
if(!session::existsAttribute("LOGEADO")){
	//header("location: index.php");
}

$conn = NEW DBManejador();
if($conn == null){
	header('Location: /util/errorConexion.html');
}
$idrol = session::getAttribute("IDROL");
$usuario =session::getAttribute("USUARIO");
$nombre = session::getAttribute("NOMBRE");
$idemp = session::getAttribute("IDEMPRESA");

$rs_emp = $conn->consultarCondicion("empresa", "gen_empresas", "id_empresa = :v1", array(":v1" => $idemp));
echo "<br>Empresa ".$rs_emp[0]["empresa"];

//$rs_rol = $conn->consultarCondicion("empresa", "gen_empresas", "id_empresa = :v1", array(":v1" => $idemp));

$columnas = "rr.id_recurso,id_tipo_recurso,recurso,url";
$tabla = "seg_rol_recurso rr INNER JOIN seg_recursos r ON (rr.id_recurso = r.id_recurso)";
$condicion = "rr.id_rol = :v1";
$valores = array(":v1" => $idrol);
$rs_recurso = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

$recurso = $rs_recurso[0]["recurso"];
echo "<br>Recurso ".$rs_recurso[0]["recurso"];
if($recurso == "*"){
	
}else{
	
}

echo "<br>Usuario ".$usuario;
echo "<br>Rol ".$usuario;

?>
<br><br>
<a href="../contacto/respuestaContacto.html">Administracion Contactos</a>
</body>
</html>
