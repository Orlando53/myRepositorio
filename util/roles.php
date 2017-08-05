<?php
/*
 * @autor:        Juan Diego Ninco Collazos
 * @fecha:        2017-25-07
 * @Objetivo:     consulta los roles para cargarlos en un combo
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';

$db = new DBManejador();

$columnas = "id_rol,rol";
$tabla    = "seg_roles";
$rs       = $db->consultar($columnas, $tabla, true);

if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_rol']] = $rs[$i]['id_rol'] = $rs[$i]['rol'];
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
