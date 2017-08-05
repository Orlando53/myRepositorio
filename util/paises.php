<?php
/*
 * @autor:        Juan Diego Ninco Collazos
 * @fecha:        25-07-2017
 * @Objetivo:     consultar paises y cargar combo
 *
 */

date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';

$db       = new DBManejador();
$columnas = "id_pais, codigo_pais, pais";
$tabla    = "gen_pais";
$rs       = $db->consultar($columnas, $tabla, true);
if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_pais']] = $rs[$i]['id_pais'] = $rs[$i]['pais'];
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
