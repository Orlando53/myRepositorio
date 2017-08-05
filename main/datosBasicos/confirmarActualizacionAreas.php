<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-24-07
 * @objetivo: Actualizar áreas de trabajo
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
include_once '../../rsc/session.php';

$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}

$id_empresa   = $_SESSION['IDEMPRESA'];
$id_area      = $_POST['idArea'];
$area_trabajo = strtoupper($_POST['area_trabajo']);
$descripcion  = $_POST['descripcion'];

$respuesta = new stdClass();

$tabla     = "gen_areas_trabajo";
$campos    = "area_trabajo = :v1, descripcion =:v2";
$condicion = "id_empresa = :v3 and id_area_trabajo = :v4";
$valores   = array(":v1" => $area_trabajo, ":v2" => $descripcion, ":v3" => $id_empresa, ":v4" => $id_area);

$rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);
echo 1;
//echo $respuesta->mensaje = 'Registro actualizado satisfactoriamente.';
