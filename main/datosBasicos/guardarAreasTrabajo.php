<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Guardar áreas de trabajo
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
$area_trabajo = mb_strtoupper($_POST['nombre']);
$descripcion  = ucfirst($_POST['descripcion']);
$respuesta    = new stdClass();

$columnasc  = "area_trabajo";
$tablac     = "gen_areas_trabajo";
$condicionc = "area_trabajo = :v1 AND id_empresa = :v2 AND estado = :v3";
$valoresc   = array(":v1" => $area_trabajo, ":v2" => $id_empresa, ":v3" => '1');

$rs_c = $conn->consultarCondicion($columnasc, $tablac, $condicionc, $valoresc);

if (empty($rs_c)) {
    $tabla    = "gen_areas_trabajo";
    $columnas = "id_empresa, area_trabajo, descripcion, estado";
    $campos   = ":v1, :v2, :v3, :v4";
    $valores  = array(":v1" => $id_empresa, ":v2" => $area_trabajo, ":v3" => $descripcion, ":v4" => '1');

    $rs_agregar = $conn->agregar($tabla, $columnas, $campos, $valores);

    echo 1;
    //echo $respuesta->mensaje = 'Area de trabajo registrada';
} else {
    echo 0;
    //echo $respuesta->mensaje = 'El área de trabajo que intenta agregar ya se encuentra registrada';
}
