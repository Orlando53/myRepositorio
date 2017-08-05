<?php
/*
 * @autor:        Juan Diego Ninco  Collazos
 * @fecha:        25-07-2017
 * @Objetivo:     consultar centros poblados para listar en combos
 *
 */

date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';

$db = new DBManejador();
$id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

$campos    = "id_centro_poblado, centro_poblado";
$tabla     = "gen_centro_poblado";
$condicion = "codigo_municipio = :v1";
$valores   = array(":v1" => $id);
$rs        = $db->consultarCondicion($campos, $tabla, $condicion, $valores);
if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_centro_poblado']] = $rs[$i]['id_centro_poblado'] = $rs[$i]['centro_poblado'];
}

$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
