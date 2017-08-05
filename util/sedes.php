<?php
/*
 * @autor:        Juan Diego Ninco Collazos
 * @fecha:        julio 25 de 2017
 * @Objetivo:     consultar sedes o sucursales
 *
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');

include_once '../rsc/DBManejador.php';
include_once '../rsc/session.php';
$db        = new DBManejador();
$idEmpresa = session::getAttribute('IDEMPRESA');

$columnas  = "id_sucursal, razon_social";
$tabla     = "gen_sucursales";
$condicion = "id_empresa=:v1";
$valores   = array(":v1" => $idEmpresa);

$rs = $db->consultarCondicion($columnas, $tabla, $condicion, $valores);
if ($rs == null) {
    echo 0;
    exit();
}

$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_sucursal']] = $rs[$i]['id_sucursal'] = $rs[$i]['razon_social'];
}

$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
