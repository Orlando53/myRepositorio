<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Eliminar áreas de trabajo
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

$id_empresa = $_SESSION['IDEMPRESA'];

//$id_empresa = '1';

foreach ($_POST['IdsAreas'] as $idareas) {

    $tabla     = "gen_areas_trabajo";
    $campos    = "estado = :v1";
    $condicion = "id_empresa = :v2 and id_area_trabajo = :v3";
    $valores   = array(":v1" => '0', ":v2" => $id_empresa, ":v3" => $idareas);

    $rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);

}
echo 1;
//echo $respuesta->mensaje = 'Registro eliminado satisfactoriamente.';
