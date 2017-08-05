<?php
/*
* @autor:		Orlando Puentes A.
* @fecha:		julio 21 de 2017
* @Objetivo:	Conbo dinamico departamentos
*
*/

date_default_timezone_set('America/Bogota'); 
ini_set("display_errors",'1');

include_once '../rsc/DBManejador.php';
$db = new DBManejador();
$ide = !empty($_REQUEST['id'])?intval($_REQUEST['id']):0;
$campos    = "codigo_departamento,departamento";
$tabla     = "gen_departamentos";
$condicion = "id_pais = :v1";
$valores = array(":v1" => $ide);
$rs = $db->consultarCondicion($campos, $tabla, $condicion, $valores);    
if ($rs == NULL) {
	echo  0;
	exit();
} 
 $items = array(); 
for($i = 0; $i < count($rs); $i++){
	$items[$rs[$i]['codigo_departamento']] = $rs[$i]['codigo_departamento'] = $rs[$i]['departamento'];
}
$response = isset($_GET['callback'])?$_GET['callback']."(".json_encode($items).")":json_encode($items); 
//$cache->finish($response);
echo $response;    
?>