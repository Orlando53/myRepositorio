<?php

/* !
 * autor:		Walther Rojas 
 * fecha:		julio 25 de 2017
 * objetivo: 	 
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
include_once '../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: index.php");
}

$conn = NEW DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}

$id_empresa = session::getAttribute('IDEMPRESA');
$columnas = "paso1, paso2, paso3, paso4, paso5, paso6, paso7";
$tabla = "gen_control_pro_inicio";
$condicion = "id_empresa=:v1";
$valores = array(':v1' => $id_empresa);
$rs_control = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
echo json_encode($rs_control);
