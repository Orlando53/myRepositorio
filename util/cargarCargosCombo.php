<?php
/*
 * @autor:        Jose Eric Castro Cuadrado
 * @fecha:        2017-24-07
 * @Objetivo:    Carga los cargos en un combo
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$db = new DBManejador();
if ($db == null) {
    echo -1;
    exit(0);
}

$id_empresa = $_SESSION['IDEMPRESA'];
$estado     = !empty($_REQUEST['estado']) ? intval($_REQUEST['estado']) : 0;

$campos    = "id_cargo, cargo";
$tabla     = "gen_cargos";
$condicion = "id_empresa = :v1 AND estado = :v2";
$valores   = array(":v1" => $id_empresa, ":v2" => $estado);
$rs        = $db->consultarCondicion($campos, $tabla, $condicion, $valores);

if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_cargo']] = $rs[$i]['id_cargo'] = $rs[$i]['cargo'];
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
