<?php
/*
 * @autor:        Juan Diego Ninco Collazos
 * @fecha:        2017-25-07
 * @Objetivo:     consulta las areas para cargarlas en un combo
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
include_once '../rsc/session.php';

$db         = new DBManejador();
$id_empresa = session::getAttribute('IDEMPRESA');
$estado     = !empty($_REQUEST['estado']) ? intval($_REQUEST['estado']) : 0;

$campos    = "id_area_trabajo, area_trabajo";
$tabla     = "gen_areas_trabajo";
$condicion = "id_empresa = :v1 AND estado = :v2";
$valores   = array(":v1" => $id_empresa, ":v2" => $estado);
$rs        = $db->consultarCondicion($campos, $tabla, $condicion, $valores);

if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_area_trabajo']] = $rs[$i]['area_trabajo'] = $rs[$i]['area_trabajo'];
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
