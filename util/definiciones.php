<?php
/*
* @autor:		Orlando Puentes A.
* @fecha:		julio 21 de 2017
* @Objetivo:	Combo dinamico departamentos - municipios
*
*/

date_default_timezone_set('America/Bogota'); 
ini_set("display_errors",'1');

include_once '../rsc/DBManejador.php';
$db = new DBManejador();
$idd = !empty($_REQUEST['id'])?intval($_REQUEST['id']):0;

$columnas = "id_detalle_definicion, detalle_definicion";
$tabla = "gen_detalle_definicion";
$condicion = "id_definicion=:v1";
$valores = array(":v1" => $idd);

$rs = $db->consultarCondicion($columnas, $tabla, $condicion, $valores);
if ($rs == NULL) {
	echo  0;
	exit();
} 
 $items = array(); 
for($i = 0; $i < count($rs); $i++){
	$items[$rs[$i]['id_detalle_definicion']] = $rs[$i]['id_detalle_definicion'] = $rs[$i]['detalle_definicion'];
}

$response = isset($_GET['callback'])?$_GET['callback']."(".json_encode($items).")":json_encode($items); 
//$cache->finish($response);
echo $response;    

?>