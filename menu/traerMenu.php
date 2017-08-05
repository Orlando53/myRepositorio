<?php
/*
* @autor:		orlando puentes andrade	
* @fecha:		julio 13 de 2017
* @objetivo:	traer el menu de acuedo al rol del usuario
*/

@session_start();
date_default_timezone_set('America/Bogota'); 
ini_set("display_errors",'1');
include_once '../rsc/DBManejador.php';
require_once '../rsc/session.php';
if(!session::existsAttribute("LOGEADO")){
	header("location: index.php");
}

$conn = NEW DBManejador();
if($conn == null){
	echo -1;
	exit(0);
}
$ubicacion = $_REQUEST['v1'];

$columnas = "m.id_menu,m.orden,menu,ubicacion";
$tabla = "gen_menu m";
$condicion = "m.estado = :v1 AND ubicacion = :v2";
$valores = array(':v1' => 1 , ':v2' => $ubicacion);
$rs_menu = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
echo json_encode($rs_menu);

?>