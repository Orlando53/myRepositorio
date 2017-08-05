<?php
/*
 * @autor:        Juan Diego Ninco Collazos
 * @fecha:        25-07-2017
 * @Objetivo:     Consulta personas de la empresa para el combo de jefe inmediato
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';

$db = new DBManejador();

$db         = new DBManejador();
$estado     = $_REQUEST['estado'];
$id_empresa = $_SESSION['IDEMPRESA'];

$campos    = "e.id_persona, CONCAT_WS(' ',COALESCE(primer_nombre,' '),COALESCE(segundo_nombre,' '),COALESCE(primer_apellido,' '),COALESCE(segundo_apellido) ) AS nombre ";
$tabla     = "gen_personas as p INNER JOIN ges_empleados as e ON e.id_persona=p.id_persona";
$condicion = "estado_empleado=:v1 AND e.id_empresa=:v2";
$valores   = array(":v1" => $estado, ":v2" => $id_empresa);
$rs        = $db->consultarCondicion($campos, $tabla, $condicion, $valores);
if ($rs == null) {
    echo 0;
    exit();
}
$items = array();
for ($i = 0; $i < count($rs); $i++) {
    $items[$rs[$i]['id_persona']] = $rs[$i]['id_persona'] = $rs[$i]['nombre'];
}
$response = isset($_GET['callback']) ? $_GET['callback'] . "(" . json_encode($items) . ")" : json_encode($items);
//$cache->finish($response);
echo $response;
